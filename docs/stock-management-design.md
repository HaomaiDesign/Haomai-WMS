# Diseño de Gestión de Stock - Haomai WMS

> Documento de arquitectura y decisiones técnicas para el manejo de inventario.

---

## 1. Contexto y Problema

### 1.1 Problema a Resolver

El sistema WMS necesita gestionar stock con las siguientes características:

- **Alto volumen**: Se esperan cientos de miles de movimientos de stock (500K+)
- **Consultas frecuentes**: Listados de stock por warehouse, filtros por categoría, validación de disponibilidad antes de ventas
- **Trazabilidad completa**: Auditoría de quién, cuándo y por qué cambió el stock
- **Multi-warehouse**: Un producto puede estar en múltiples almacenes
- **Gestión de lotes**: Control de fechas de vencimiento y FEFO (First Expired, First Out)

### 1.2 Problema de Escalabilidad

El enfoque tradicional de calcular stock on-demand mediante agregación:

```sql
SELECT producto_id, SUM(cantidad) FROM movimientos GROUP BY producto_id
```

**No escala** con el volumen esperado:

| Volumen de movimientos | Tiempo de consulta |
|------------------------|-------------------|
| 10K | ~50ms |
| 100K | ~500ms |
| 500K | ~2-5 segundos |
| 1M | ~10+ segundos |

Esto es inaceptable para operaciones en tiempo real como:
- Validar stock antes de confirmar una venta
- Mostrar listados paginados de inventario
- Dashboards de stock en tiempo real

### 1.3 Alternativas Evaluadas

| Alternativa | Ventajas | Desventajas |
|-------------|----------|-------------|
| **UPDATE directo de stock** | Simple, rápido | Sin trazabilidad, pérdida de historial, inconsistencias |
| **Cálculo on-demand (SUM)** | Siempre correcto | No escala, lento con volumen |
| **View normal** | Sin código extra | Misma lentitud que on-demand |
| **Indexed View (SQL Server)** | Auto-mantenida | Restricciones técnicas, poco flexible |
| **Snapshot + Logs (elegido)** | Rápido, trazable, flexible | Requiere sincronización manual |

### 1.4 Decisión: Event Sourcing Light

Se eligió el modelo de **Event Sourcing Light** porque:

1. **Trazabilidad completa**: Cada cambio de stock genera un registro inmutable
2. **Consultas rápidas**: El snapshot (`stockSnapshot`) permite O(1) en lecturas
3. **Consistencia garantizada**: Transacciones atómicas actualizan ambas tablas
4. **Auditoría integrada**: Se puede reconstruir el estado del stock a cualquier punto en el tiempo
5. **Flexibilidad**: Sin restricciones técnicas de indexed views
6. **Verificación**: Job de reconciliación detecta bugs o inconsistencias

### 1.5 Ejemplo: O(1) vs O(N)

#### ❌ Sin snapshot (O(N) - debe recorrer N movimientos):
```sql
-- Para obtener el stock de 1 producto, debe sumar TODOS sus movimientos
SELECT SUM(quantityDelta) 
FROM stockLogs 
WHERE productId = 123 AND warehouseId = 1;

-- Si el producto tiene 10,000 movimientos históricos,
-- SQL Server debe leer las 10,000 filas y sumarlas
-- Tiempo: O(N) donde N = cantidad de movimientos
```

#### ✅ Con snapshot (O(1) - acceso directo):
```sql
-- El stock ya está calculado, es un simple lookup
SELECT quantity 
FROM stockSnapshot 
WHERE productId = 123 AND warehouseId = 1 AND lotId = 5;

-- Con índice, SQL Server va DIRECTO a la fila
-- No importa si hubo 10 o 10,000,000 de movimientos históricos
-- Tiempo: O(1) - constante
```

#### Visualización:
```
Sin Snapshot (O(N)):
┌─────────────────────────────────────────────────────────┐
│ SELECT SUM(quantityDelta) FROM stockLogs                │
│                                                         │
│   📦+100 → 📦+50 → 📦-30 → 📦+20 → ... → 📦-10         │
│     ↓        ↓       ↓        ↓             ↓          │
│   leer    leer    leer    leer    ...    leer          │
│                                                         │
│   Total: Leer N filas, sumar N valores                  │
└─────────────────────────────────────────────────────────┘

Con Snapshot (O(1)):
┌─────────────────────────────────────────────────────────┐
│ SELECT quantity FROM stockSnapshot WHERE ...            │
│                                                         │
│   📊 quantity = 130  ← Valor pre-calculado              │
│        ↓                                                │
│      leer                                               │
│                                                         │
│   Total: Leer 1 fila, sin cálculos                      │
└─────────────────────────────────────────────────────────┘
```

---

## 2. Enfoque Adoptado: Event Sourcing Light

### ❌ Qué NO se hace
- No se actualiza el stock actual directamente desde operaciones de negocio
- No existe `UPDATE stock` directo
- El stock no se pisa ni recalcula manualmente

### ✅ Principios
- El stock se **deriva** de un historial de **movimientos** (source of truth)
- Cada operación genera un **registro de movimiento**, no una actualización directa
- Se mantiene un **snapshot materializado** (`stockSnapshot`) para consultas rápidas
- Ambas operaciones ocurren en **transacción atómica**

---

## 3. Modelo de Datos

### 2.1 Entidades Principales

#### `lots` - Lotes de Productos
```sql
CREATE TABLE lots (
    id INT IDENTITY PRIMARY KEY,
    lotNumber VARCHAR(100) NOT NULL,
    expiryDate DATE NOT NULL,
    receivedDate DATE NOT NULL DEFAULT GETDATE(),
    status VARCHAR(20) NOT NULL DEFAULT 'PENDING' CHECK (status IN ('PENDING', 'RECEIVED', 'EXPIRED')),
    productId INT NOT NULL FOREIGN KEY REFERENCES products(id),
    warehouseId INT NOT NULL FOREIGN KEY REFERENCES warehouse(id),
    createdAt DATETIME2 DEFAULT GETUTCDATE(),
    
    INDEX IX_lots_product_warehouse (productId, warehouseId),
    INDEX IX_lots_expiry (expiryDate),
    INDEX IX_lots_status (status)
);
```

#### `product_barcodes` - Múltiples Barcodes por Producto
```sql
CREATE TABLE product_barcodes (
    id INT IDENTITY PRIMARY KEY,
    barcode VARCHAR(100) NOT NULL UNIQUE,
    type VARCHAR(10) NOT NULL DEFAULT 'UNIT' CHECK (type IN ('UNIT', 'PACK')),
    isPrimary BIT DEFAULT 0,
    productId INT NOT NULL FOREIGN KEY REFERENCES products(id),
    createdAt DATETIME2 DEFAULT GETUTCDATE(),
    
    INDEX IX_barcodes_product (productId)
);
```

#### `barcode_pack_contents` - Contenido de Packs (N:M)
```sql
CREATE TABLE barcode_pack_contents (
    id INT IDENTITY PRIMARY KEY,
    packBarcodeId INT NOT NULL,
    unitBarcodeId INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    
    CONSTRAINT UQ_pack_unit UNIQUE (packBarcodeId, unitBarcodeId),
    FOREIGN KEY (packBarcodeId) REFERENCES product_barcodes(id),
    FOREIGN KEY (unitBarcodeId) REFERENCES product_barcodes(id),
    
    INDEX IX_bpc_unit (unitBarcodeId)
);
```

#### `stockSnapshot` - Snapshot de Stock (Vista Materializada)
```sql
CREATE TABLE stockSnapshot (
    id INT IDENTITY PRIMARY KEY,
    productId INT NOT NULL,
    warehouseId INT NOT NULL,
    lotId INT NOT NULL,
    quantity DECIMAL(16,2) NOT NULL DEFAULT 0,
    lastMovementId BIGINT NULL,
    updatedAt DATETIME2 DEFAULT GETUTCDATE(),
    
    CONSTRAINT UQ_stockSnapshot_product_warehouse_lot 
        UNIQUE (productId, warehouseId, lotId),
    
    FOREIGN KEY (productId) REFERENCES products(id),
    FOREIGN KEY (warehouseId) REFERENCES warehouse(id),
    FOREIGN KEY (lotId) REFERENCES lots(id),
    
    INDEX IX_stockSnapshot_warehouse (warehouseId) INCLUDE (productId, quantity),
    INDEX IX_stockSnapshot_product (productId) INCLUDE (warehouseId, quantity)
);
```

#### `stockLogs` - Historial de Movimientos (Source of Truth)
```sql
CREATE TABLE stockLogs (
    id BIGINT IDENTITY PRIMARY KEY,
    productId INT NOT NULL,
    warehouseId INT NOT NULL,
    lotId INT NOT NULL,
    date DATETIME2 NOT NULL DEFAULT GETUTCDATE(),
    type VARCHAR(20) NOT NULL CHECK (type IN ('IN', 'OUT', 'ADJUST', 'TRANSFER')),
    quantityDelta DECIMAL(16,2) NOT NULL,
    description NVARCHAR(500) NULL,
    userId INT NOT NULL,
    orderId INT NULL,
    
    FOREIGN KEY (productId) REFERENCES products(id),
    FOREIGN KEY (warehouseId) REFERENCES warehouse(id),
    FOREIGN KEY (lotId) REFERENCES lots(id),
    FOREIGN KEY (userId) REFERENCES users(id),
    FOREIGN KEY (orderId) REFERENCES orders(id),
    
    INDEX IX_stockLogs_product_warehouse (productId, warehouseId, lotId),
    INDEX IX_stockLogs_date (date),
    INDEX IX_stockLogs_order (orderId)
);
```

#### Actualización de `orderDetails`
```sql
ALTER TABLE orderDetails ADD lotId INT NULL FOREIGN KEY REFERENCES lots(id);
```

---

## 4. Reglas de Negocio

### 6.1 Inmutabilidad de Movimientos
- ✅ Los movimientos **nunca se borran ni modifican**
- ✅ Correcciones se hacen con **movimientos compensatorios** (ADJUST)
- ✅ El stock siempre puede reconstruirse desde los movimientos

### 6.2 FEFO (First Expired, First Out)
- En egresos, el sistema sugiere descontar del **lote más próximo a vencer**
- El usuario puede modificar la distribución manualmente
- Se registra en `orderDetails.lotId` el lote efectivamente usado

### 4.3 Múltiples Barcodes
- Un producto puede tener N barcodes asociados
- Al escanear un barcode existente → precargar producto
- Al escanear barcode nuevo → opción de crear producto o vincular a existente

### 4.4 Multi-Warehouse
- El stock se mantiene por `(productId, warehouseId, lotId)`
- Se puede consultar stock por warehouse específico o total

---

## 5. Estrategia de Sincronización

### 6.1 Transacción Atómica
```
┌─────────────────────────────────────────────────────┐
│  BEGIN TRANSACTION                                  │
│                                                     │
│  1. INSERT INTO stockLogs (...)               │
│  2. UPDATE/MERGE stockSnapshot SET quantity += delta    │
│                                                     │
│  COMMIT                                             │
└─────────────────────────────────────────────────────┘
```

- **Delay:** 0ms (ambas operaciones son sincrónicas)
- **Consistencia:** 100% (si una falla, ambas se revierten)

### 6.2 Job de Reconciliación (Seguridad)
```sql
-- Detectar inconsistencias (debería retornar 0 filas)
SELECT 
    m.productId, m.warehouseId, m.lotId,
    SUM(m.quantityDelta) AS calculado,
    i.quantity AS snapshot
FROM stockLogs m
LEFT JOIN stockSnapshot i ON i.productId = m.productId 
    AND i.warehouseId = m.warehouseId 
    AND i.lotId = m.lotId
GROUP BY m.productId, m.warehouseId, m.lotId, i.quantity
HAVING ABS(SUM(m.quantityDelta) - ISNULL(i.quantity, 0)) > 0.001;
```

---

## 6. Optimización: Stored Procedures con TVP

### 6.1 Type Definition
```sql
CREATE TYPE dbo.EgresoItemType AS TABLE (
    productId INT NOT NULL,
    lotId INT NOT NULL,
    warehouseId INT NOT NULL,
    quantity DECIMAL(16,2) NOT NULL,
    itemPrice DECIMAL(16,2) NULL,
    productName VARCHAR(200) NULL,
    productSku VARCHAR(100) NULL
);
```

### 6.2 SP de Egreso
```sql
    -- businessId deleted
    CREATE PROCEDURE dbo.sp_ProcesarEgreso
    @userId INT,
    @customerId INT,
    @warehouseId INT,
    @items dbo.EgresoItemType READONLY
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;
        
        -- 1. INSERT order (1 query)
        DECLARE @orderId INT;
        INSERT INTO orders (...) VALUES (...);
        SET @orderId = SCOPE_IDENTITY();
        
        -- 2. Bulk INSERT orderDetails (1 query)
        INSERT INTO orderDetails (orderId, productId, lotId, ...)
        SELECT @orderId, productId, lotId, ... FROM @items;
        
        -- 3. Bulk INSERT stockLogs (1 query)
        INSERT INTO stockLogs (productId, lotId, quantityDelta, ...)
        SELECT productId, lotId, -quantity, ... FROM @items;
        
        -- 4. Batch UPDATE stockSnapshot (1 query)
        UPDATE inv
        SET inv.quantity = inv.quantity - i.quantity, inv.updatedAt = GETDATE()
        FROM stockSnapshot inv
        INNER JOIN @items i ON inv.productId = i.productId 
            AND inv.lotId = i.lotId 
            AND inv.warehouseId = i.warehouseId;
        
        -- 5. Validar stock no negativo
        IF EXISTS (SELECT 1 FROM stockSnapshot WHERE quantity < 0 ...)
        BEGIN
            RAISERROR('Stock insuficiente', 16, 1);
            ROLLBACK; RETURN;
        END
        
        COMMIT;
        SELECT @orderId AS orderId;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0 ROLLBACK;
        THROW;
    END CATCH
END
```

### 6.3 Performance
| Sin SP | Con SP + TVP |
|--------|--------------|
| 601 queries (200 items) | 5 queries |
| ~500ms | ~50-100ms |
| 601 round-trips | 1 round-trip |

---

## 7. Consultas Comunes

### Stock por Warehouse
```sql
SELECT p.id, p.name, SUM(i.quantity) AS stock
FROM products p
JOIN stockSnapshot i ON i.productId = p.id
WHERE i.warehouseId = @warehouseId
GROUP BY p.id, p.name;
```

### Stock Total (todos los warehouses)
```sql
SELECT p.id, p.name, SUM(i.quantity) AS stock_total
FROM products p
JOIN stockSnapshot i ON i.productId = p.id
GROUP BY p.id, p.name;
```

### Stock por Lote (para FEFO)
```sql
SELECT l.id, l.lotNumber, l.expiryDate, i.quantity
FROM stockSnapshot i
JOIN lots l ON l.id = i.lotId
WHERE i.productId = @productId AND i.warehouseId = @warehouseId AND i.quantity > 0
ORDER BY l.expiryDate ASC;
```

---

## 8. Diagrama de Flujo

```
                    ┌──────────────┐
                    │   products   │
                    └──────┬───────┘
                           │
          ┌────────────────┼────────────────┐
          │                │                │
          ▼                ▼                ▼
┌──────────────────┐ ┌──────────┐  ┌─────────────────┐
│ product_barcodes │ │   lots   │  │ stockLogs │
│   (N barcodes)   │ │ (lotes)  │  │  (source of     │
└──────────────────┘ └────┬─────┘  │     truth)      │
                          │        └────────┬────────┘
                          │                 │
                          ▼                 ▼
                    ┌───────────────────────────┐
                    │        stockSnapshot          │
                    │  (snapshot materializado) │
                    └───────────────────────────┘
```

---

## 9. Beneficios del Enfoque

| Beneficio | Descripción |
|-----------|-------------|
| **Trazabilidad** | Historial completo de cada movimiento |
| **Auditoría** | Quién, cuándo, qué, por qué de cada cambio |
| **Consistencia** | Transacciones atómicas garantizan integridad |
| **Performance** | Consultas O(1) sobre snapshot indexado |
| **Escalabilidad** | Soporta millones de movimientos |
| **Rollback lógico** | Movimientos compensatorios sin borrar datos |
