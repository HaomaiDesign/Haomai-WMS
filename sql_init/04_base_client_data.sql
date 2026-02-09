-- Base client data for Haomai WMS
-- This migration contains initial data to populate tables with client-specific information
-- NOTE: This file will be updated as new client data needs to be added
USE haomai_wms;
GO

-- ============================================
-- SECTION: Business / Company Data
-- ============================================
-- Add your business/company records here
-- Example:
-- INSERT INTO dbo.businesses (name, ...) VALUES ('Client Company', ...);

-- ============================================
-- SECTION: Warehouse Locations
-- ============================================
-- Add warehouse location records here
-- Example:
-- INSERT INTO dbo.warehouses (name, address, ...) VALUES ('Main Warehouse', '123 Industrial Blvd', ...);

-- ============================================
-- SECTION: Product Categories
-- ============================================
-- Add product category records here
-- Example:
-- INSERT INTO dbo.categories (name, description) VALUES ('Electronics', 'Electronic devices and components');

-- ============================================
-- SECTION: Initial Inventory
-- ============================================
-- Add initial inventory/product records here
-- Example:
-- INSERT INTO dbo.products (sku, name, category_id, ...) VALUES ('SKU-001', 'Product Name', 1, ...);

-- ============================================
-- SECTION: Supplier Data
-- ============================================
-- Add supplier records here
-- Example:
-- INSERT INTO dbo.suppliers (name, contact, ...) VALUES ('Supplier Corp', 'contact@supplier.com', ...);

-- ============================================
-- SECTION: Additional Client Users
-- ============================================
-- Add additional client-specific users here (beyond the default system users)
-- Example:
-- INSERT INTO dbo.users (username, email, password, full_name, role, business_id)
-- VALUES ('warehouse_manager', 'manager@client.com', '$2b$10$...', 'Warehouse Manager', 'ADMIN', 1);

PRINT 'Base client data loaded successfully';