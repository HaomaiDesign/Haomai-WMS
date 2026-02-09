-- SQL Server migration script for Haomai WMS
-- Migration: 06_create_wms_model.sql
-- Creates all core WMS tables with proper FK ordering

USE haomai_wms;
GO

-- =============================================
-- 1. WAREHOUSE
-- =============================================
IF OBJECT_ID('dbo.warehouse', 'U') IS NULL BEGIN
CREATE TABLE dbo.warehouse (
    id INT IDENTITY(1, 1) PRIMARY KEY,
    name NVARCHAR(500) NOT NULL,
    business_id INT NOT NULL,
    created_at DATETIME2 DEFAULT GETDATE(),
    updated_at DATETIME2 DEFAULT GETDATE(),
    CONSTRAINT FK_warehouse_business FOREIGN KEY (business_id) REFERENCES dbo.business (id)
);

CREATE INDEX idx_warehouse_business ON dbo.warehouse (business_id);

PRINT 'Table dbo.warehouse created successfully';

END ELSE PRINT 'Table dbo.warehouse already exists, skipping';
GO

-- =============================================
-- 2. PRODUCTS
-- =============================================
IF OBJECT_ID('dbo.products', 'U') IS NULL BEGIN
CREATE TABLE dbo.products (
    id INT IDENTITY(1, 1) PRIMARY KEY,
    sku NVARCHAR(200) NULL,
    name NVARCHAR(500) NOT NULL,
    category NVARCHAR(500) NULL,
    capacity NVARCHAR(100) NULL,
    unit NVARCHAR(100) NULL,
    brand NVARCHAR(500) NULL,
    pack_wholesale INT NULL,
    description NVARCHAR(MAX) NULL,
    image NVARCHAR(1000) NULL,
    due_date DATE NULL,
    flag_discontinued BIT DEFAULT 0,
    flag_active BIT DEFAULT 1,
    business_id INT NOT NULL,
    created_at DATETIME2 DEFAULT GETDATE(),
    updated_at DATETIME2 DEFAULT GETDATE(),
    CONSTRAINT FK_products_business FOREIGN KEY (business_id) REFERENCES dbo.business (id)
);

CREATE INDEX idx_products_business ON dbo.products (business_id);

CREATE INDEX idx_products_sku ON dbo.products (sku);

CREATE INDEX idx_products_name ON dbo.products (name);

PRINT 'Table dbo.products created successfully';

END ELSE PRINT 'Table dbo.products already exists, skipping';
GO

-- =============================================
-- 3. SUPPLIERS
-- =============================================
IF OBJECT_ID('dbo.suppliers', 'U') IS NULL BEGIN
CREATE TABLE dbo.suppliers (
    id INT IDENTITY(1, 1) PRIMARY KEY,
    business_name NVARCHAR(1000) NULL,
    tax_id NVARCHAR(1000) NULL,
    address NVARCHAR(1000) NULL,
    phone NVARCHAR(1000) NULL,
    email NVARCHAR(1000) NULL,
    business_id INT NOT NULL,
    created_at DATETIME2 DEFAULT GETDATE(),
    updated_at DATETIME2 DEFAULT GETDATE(),
    CONSTRAINT FK_suppliers_business FOREIGN KEY (business_id) REFERENCES dbo.business (id)
);

CREATE INDEX idx_suppliers_business ON dbo.suppliers (business_id);

PRINT 'Table dbo.suppliers created successfully';

END ELSE PRINT 'Table dbo.suppliers already exists, skipping';
GO

-- =============================================
-- 4. CUSTOMERS
-- =============================================
IF OBJECT_ID('dbo.customers', 'U') IS NULL BEGIN
CREATE TABLE dbo.customers (
    id INT IDENTITY(1, 1) PRIMARY KEY,
    business_name NVARCHAR(1000) NULL,
    tax_id NVARCHAR(1000) NULL,
    address NVARCHAR(1000) NULL,
    phone NVARCHAR(1000) NULL,
    email NVARCHAR(1000) NULL,
    business_id INT NOT NULL,
    created_at DATETIME2 DEFAULT GETDATE(),
    updated_at DATETIME2 DEFAULT GETDATE(),
    CONSTRAINT FK_customers_business FOREIGN KEY (business_id) REFERENCES dbo.business (id)
);

CREATE INDEX idx_customers_business ON dbo.customers (business_id);

PRINT 'Table dbo.customers created successfully';

END ELSE PRINT 'Table dbo.customers already exists, skipping';
GO

-- =============================================
-- 5. LOTS (Lotes de Productos)
-- =============================================
IF OBJECT_ID('dbo.lots', 'U') IS NULL BEGIN
CREATE TABLE dbo.lots (
    id INT IDENTITY(1, 1) PRIMARY KEY,
    expiry_date DATE NOT NULL,
    received_date DATE NULL DEFAULT GETDATE(),
    status VARCHAR(20) NOT NULL DEFAULT 'PENDING' CHECK (
        status IN (
            'PENDING',
            'RECEIVED',
            'EXPIRED'
        )
    ),
    product_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    created_at DATETIME2 DEFAULT GETDATE(),
    updated_at DATETIME2 DEFAULT GETDATE(),
    CONSTRAINT FK_lots_product FOREIGN KEY (product_id) REFERENCES dbo.products (id),
    CONSTRAINT FK_lots_warehouse FOREIGN KEY (warehouse_id) REFERENCES dbo.warehouse (id)
);

CREATE
INDEX idx_lots_product_warehouse ON dbo.lots (product_id, warehouse_id);

CREATE INDEX idx_lots_expiry ON dbo.lots (expiry_date);

CREATE INDEX idx_lots_status ON dbo.lots (status);

PRINT 'Table dbo.lots created successfully';

END ELSE PRINT 'Table dbo.lots already exists, skipping';
GO

-- =============================================
-- 6. PRODUCT_BARCODES (N barcodes por producto)
-- =============================================
IF OBJECT_ID('dbo.product_barcodes', 'U') IS NULL BEGIN
CREATE TABLE dbo.product_barcodes (
    id INT IDENTITY(1, 1) PRIMARY KEY,
    barcode NVARCHAR(200) NOT NULL,
    type VARCHAR(10) NOT NULL DEFAULT 'UNIT' CHECK (
        type IN ('UNIT', 'PACK')
    ),
    is_primary BIT DEFAULT 0,
    product_id INT NOT NULL,
    created_at DATETIME2 DEFAULT GETDATE(),
    CONSTRAINT UQ_product_barcodes_barcode UNIQUE (barcode),
    CONSTRAINT FK_product_barcodes_product FOREIGN KEY (product_id) REFERENCES dbo.products (id)
);

CREATE
INDEX idx_product_barcodes_product ON dbo.product_barcodes (product_id);

PRINT 'Table dbo.product_barcodes created successfully';

END ELSE PRINT 'Table dbo.product_barcodes already exists, skipping';
GO

-- =============================================
-- 7. BARCODE_PACK_CONTENTS (N:M entre packs y units)
-- =============================================
IF OBJECT_ID(
    'dbo.barcode_pack_contents',
    'U'
) IS NULL BEGIN
CREATE TABLE dbo.barcode_pack_contents (
    id INT IDENTITY(1, 1) PRIMARY KEY,
    pack_barcode_id INT NOT NULL,
    unit_barcode_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    CONSTRAINT UQ_pack_unit UNIQUE (
        pack_barcode_id,
        unit_barcode_id
    ),
    CONSTRAINT FK_bpc_pack FOREIGN KEY (pack_barcode_id) REFERENCES dbo.product_barcodes (id),
    CONSTRAINT FK_bpc_unit FOREIGN KEY (unit_barcode_id) REFERENCES dbo.product_barcodes (id)
);

CREATE
INDEX idx_bpc_unit ON dbo.barcode_pack_contents (unit_barcode_id);

PRINT 'Table dbo.barcode_pack_contents created successfully';

END ELSE PRINT 'Table dbo.barcode_pack_contents already exists, skipping';
GO

-- =============================================
-- 8. ORDERS (Pedidos generales)
-- =============================================
IF OBJECT_ID('dbo.orders', 'U') IS NULL BEGIN
CREATE TABLE dbo.orders (
    id INT IDENTITY(1, 1) PRIMARY KEY,
    request_id INT NULL,
    date DATE NOT NULL DEFAULT GETDATE(),
    time TIME NOT NULL DEFAULT CAST(GETDATE() AS TIME),
    status VARCHAR(30) NOT NULL DEFAULT 'PENDING' CHECK (
        status IN (
            'PENDING',
            'PROCESSING',
            'COMPLETED',
            'CANCELLED'
        )
    ),
    flag_in_out BIT NOT NULL, -- 0 = Inbound, 1 = Outbound
    business_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at DATETIME2 DEFAULT GETDATE(),
    updated_at DATETIME2 DEFAULT GETDATE(),
    CONSTRAINT FK_orders_business FOREIGN KEY (business_id) REFERENCES dbo.business (id),
    CONSTRAINT FK_orders_user FOREIGN KEY (user_id) REFERENCES dbo.users (id)
);

CREATE INDEX idx_orders_business ON dbo.orders (business_id);

CREATE INDEX idx_orders_user ON dbo.orders (user_id);

CREATE INDEX idx_orders_status ON dbo.orders (status);

CREATE INDEX idx_orders_date ON dbo.orders (date);

PRINT 'Table dbo.orders created successfully';

END ELSE PRINT 'Table dbo.orders already exists, skipping';
GO

-- =============================================
-- 9. INBOUND_ORDERS (Ingresos)
-- =============================================
IF OBJECT_ID('dbo.inbound_orders', 'U') IS NULL BEGIN
CREATE TABLE dbo.inbound_orders (
    id INT IDENTITY(1, 1) PRIMARY KEY,
    order_id INT NOT NULL,
    supplier_id INT NOT NULL,
    created_at DATETIME2 DEFAULT GETDATE(),
    CONSTRAINT FK_inbound_order FOREIGN KEY (order_id) REFERENCES dbo.orders (id),
    CONSTRAINT FK_inbound_supplier FOREIGN KEY (supplier_id) REFERENCES dbo.suppliers (id)
);

CREATE INDEX idx_inbound_order ON dbo.inbound_orders (order_id);

CREATE INDEX idx_inbound_supplier ON dbo.inbound_orders (supplier_id);

PRINT 'Table dbo.inbound_orders created successfully';

END ELSE PRINT 'Table dbo.inbound_orders already exists, skipping';
GO

-- =============================================
-- 10. OUTBOUND_ORDERS (Egresos)
-- =============================================
IF OBJECT_ID('dbo.outbound_orders', 'U') IS NULL BEGIN
CREATE TABLE dbo.outbound_orders (
    id INT IDENTITY(1, 1) PRIMARY KEY,
    order_id INT NOT NULL,
    customer_id INT NOT NULL,
    created_at DATETIME2 DEFAULT GETDATE(),
    CONSTRAINT FK_outbound_order FOREIGN KEY (order_id) REFERENCES dbo.orders (id),
    CONSTRAINT FK_outbound_customer FOREIGN KEY (customer_id) REFERENCES dbo.customers (id)
);

CREATE INDEX idx_outbound_order ON dbo.outbound_orders (order_id);

CREATE
INDEX idx_outbound_customer ON dbo.outbound_orders (customer_id);

PRINT 'Table dbo.outbound_orders created successfully';

END ELSE PRINT 'Table dbo.outbound_orders already exists, skipping';
GO

-- =============================================
-- 11. ORDER_DETAILS (Detalle de cada pedido)
-- =============================================
IF OBJECT_ID('dbo.order_details', 'U') IS NULL BEGIN
CREATE TABLE dbo.order_details (
    id INT IDENTITY(1, 1) PRIMARY KEY,
    quantity DECIMAL(16, 2) NOT NULL,
    pack INT NULL,
    item_price DECIMAL(16, 2) NULL,
    product_name NVARCHAR(500) NULL,
    product_sku NVARCHAR(200) NULL,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    lot_id INT NULL,
    created_at DATETIME2 DEFAULT GETDATE(),
    CONSTRAINT FK_order_details_order FOREIGN KEY (order_id) REFERENCES dbo.orders (id),
    CONSTRAINT FK_order_details_product FOREIGN KEY (product_id) REFERENCES dbo.products (id),
    CONSTRAINT FK_order_details_lot FOREIGN KEY (lot_id) REFERENCES dbo.lots (id)
);

CREATE INDEX idx_order_details_order ON dbo.order_details (order_id);

CREATE
INDEX idx_order_details_product ON dbo.order_details (product_id);

CREATE INDEX idx_order_details_lot ON dbo.order_details (lot_id);

PRINT 'Table dbo.order_details created successfully';

END ELSE PRINT 'Table dbo.order_details already exists, skipping';
GO

-- =============================================
-- 12. STOCK_SNAPSHOT (Vista materializada de stock)
-- =============================================
IF OBJECT_ID('dbo.stock_snapshot', 'U') IS NULL BEGIN
CREATE TABLE dbo.stock_snapshot (
    id INT IDENTITY(1, 1) PRIMARY KEY,
    product_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    lot_id INT NOT NULL,
    quantity DECIMAL(16, 2) NOT NULL DEFAULT 0,
    last_movement_id BIGINT NULL,
    updated_at DATETIME2 DEFAULT GETDATE(),
    CONSTRAINT UQ_stock_snapshot_product_warehouse_lot UNIQUE (
        product_id,
        warehouse_id,
        lot_id
    ),
    CONSTRAINT FK_stock_snapshot_product FOREIGN KEY (product_id) REFERENCES dbo.products (id),
    CONSTRAINT FK_stock_snapshot_warehouse FOREIGN KEY (warehouse_id) REFERENCES dbo.warehouse (id),
    CONSTRAINT FK_stock_snapshot_lot FOREIGN KEY (lot_id) REFERENCES dbo.lots (id)
);

CREATE
INDEX idx_stock_snapshot_warehouse ON dbo.stock_snapshot (warehouse_id) INCLUDE (product_id, quantity);

CREATE
INDEX idx_stock_snapshot_product ON dbo.stock_snapshot (product_id) INCLUDE (warehouse_id, quantity);

PRINT 'Table dbo.stock_snapshot created successfully';

END ELSE PRINT 'Table dbo.stock_snapshot already exists, skipping';
GO

-- =============================================
-- 13. STOCK_LOGS (Source of Truth - Movimientos)
-- =============================================
IF OBJECT_ID('dbo.stock_logs', 'U') IS NULL BEGIN
CREATE TABLE dbo.stock_logs (
    id BIGINT IDENTITY(1, 1) PRIMARY KEY,
    product_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    lot_id INT NOT NULL,
    date DATETIME2 NOT NULL DEFAULT GETUTCDATE(),
    type VARCHAR(20) NOT NULL CHECK (
        type IN (
            'IN',
            'OUT',
            'ADJUST',
            'TRANSFER'
        )
    ),
    quantity_delta DECIMAL(16, 2) NOT NULL,
    description NVARCHAR(500) NULL,
    user_id INT NOT NULL,
    order_id INT NULL,
    created_at DATETIME2 DEFAULT GETDATE(),
    CONSTRAINT FK_stock_logs_product FOREIGN KEY (product_id) REFERENCES dbo.products (id),
    CONSTRAINT FK_stock_logs_warehouse FOREIGN KEY (warehouse_id) REFERENCES dbo.warehouse (id),
    CONSTRAINT FK_stock_logs_lot FOREIGN KEY (lot_id) REFERENCES dbo.lots (id),
    CONSTRAINT FK_stock_logs_user FOREIGN KEY (user_id) REFERENCES dbo.users (id),
    CONSTRAINT FK_stock_logs_order FOREIGN KEY (order_id) REFERENCES dbo.orders (id)
);

CREATE
INDEX idx_stock_logs_product_warehouse ON dbo.stock_logs (
    product_id,
    warehouse_id,
    lot_id
);

CREATE INDEX idx_stock_logs_date ON dbo.stock_logs (date);

CREATE INDEX idx_stock_logs_order ON dbo.stock_logs (order_id);

CREATE INDEX idx_stock_logs_type ON dbo.stock_logs(type);

PRINT 'Table dbo.stock_logs created successfully';

END ELSE PRINT 'Table dbo.stock_logs already exists, skipping';
GO

PRINT '============================================';

PRINT 'Migration 06_create_wms_model completed successfully';

PRINT '============================================';