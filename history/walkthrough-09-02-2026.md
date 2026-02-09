# Walkthrough - 09/02/2026

## Resumen de Sesión

Sesión de diseño de arquitectura para el **manejo de stock** en Haomai WMS.

---

## Decisiones Tomadas

### 1. Enfoque de Stock: Event Sourcing Light
- El stock se deriva de un historial de **movimientos** (source of truth)
- Se mantiene una tabla `stockSnapshot` como **snapshot materializado** para consultas rápidas
- Ambas operaciones ocurren en **transacción atómica** (cero delay, 100% consistencia)

### 2. Estructura de Datos
- **`stockLogs`**: Tabla inmutable con historial de todos los cambios
- **`stockSnapshot`**: Snapshot de stock actualizado con cada movimiento
- **`lots`**: Nueva entidad con estados (PENDING, RECEIVED, EXPIRED)
- **`product_barcodes`**: Soporte para tipos UNIT y PACK
- **`barcode_pack_contents`**: Relación N:M para definir qué contiene cada pack (e.g. Caja de 12 contiene 12 unidades)

### 3. Reglas de Negocio Definidas
- **FEFO**: First Expired, First Out - sistema sugiere lote más próximo a vencer
- **Multi-warehouse**: Stock por `(productId, warehouseId, lotId)`
- **Múltiples barcodes**: Un producto puede tener N barcodes asociados (unitarios o packs)
- **Pack Management**: Al escanear un pack, el sistema sabe cuántas unidades individuales descontar/sumar
- **Inmutabilidad**: Los movimientos nunca se borran, correcciones via ajustes

### 4. Setup de Base de Datos (Docker)
- Se eliminó el contenedor efímero `db-init`
- Se creó `sql_init/entrypoint.sh` para:
  1. Iniciar SQL Server
  2. Esperar healthcheck
  3. Ejecutar migraciones en orden (01 a 06) automáticamente
- **Migraciones creadas**:
  - `05_create_business_table.sql`
  - `06_create_wms_model.sql` (13 tablas core)

### 5. Estrategia de Performance
- **Stored Procedures con TVP** (Table-Valued Parameters) para operaciones bulk
- De 601 queries a 5 queries para una orden de 200 items
- Tiempo de procesamiento: ~500ms → ~50-100ms

### 6. Seguridad de Datos
- **Job de reconciliación** nocturno para detectar inconsistencias
- Comparación entre suma de movimientos vs snapshot de stockSnapshot

---

## Documentos Generados

- [`docs/stock-management-design.md`](file:///Users/nicogarofalo/Documents/Haomai/Haomai-WMS/docs/stock-management-design.md): Documento formal de diseño

---

## Próximos Pasos Sugeridos

1. Actualizar `DiagramaEntidadRelacion.puml` con las nuevas entidades
2. Crear scripts de migración SQL para las nuevas tablas
3. Implementar Stored Procedures en SQL Server
4. Implementar servicios en NestJS para llamar a los SPs

---

## Contexto Técnico

- **Base de datos**: SQL Server
- **Backend**: NestJS con TypeORM
- **Patrón**: Event Sourcing Light + Snapshot materializado
