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
-- SECTION: System Users (Moved from 01 and 03)
-- ============================================

-- 1. Super Admin
IF NOT EXISTS (
    SELECT 1
    FROM dbo.users
    WHERE
        username = 'superadmin'
) BEGIN
INSERT INTO
    dbo.users (
        id,
        username,
        email,
        password,
        full_name,
        role_id,
        role_type
    )
VALUES (
        NEWID(),
        'superadmin',
        'superadmin@haomai.com',
        '$2b$10$ZrWWwW0G3najeXoAZnBh/OAnhg/Z6.H2OZjJK1j98IjXtrqflVW7C', -- S4DMHaomai!
        'Super Administrator',
        1,
        'SUPER_ADMIN'
    );

PRINT 'User superadmin created';

END

-- 2. Admin
IF NOT EXISTS (
    SELECT 1
    FROM dbo.users
    WHERE
        username = 'admin'
) BEGIN
INSERT INTO
    dbo.users (
        id,
        username,
        email,
        password,
        full_name,
        role_id,
        role_type
    )
VALUES (
        NEWID(),
        'admin',
        'admin@haomai.com',
        '$2b$10$vhD2lOkAwgcT38dSm/HToeeR3LCLlKxUn1Uor/zErTc7T/pLlcTLG', -- admin123 (hashed)
        'Administrator',
        1,
        'ADMIN'
    );

PRINT 'User admin created';

END

-- 3. Employee
IF NOT EXISTS (
    SELECT 1
    FROM dbo.users
    WHERE
        username = 'employee'
) BEGIN
INSERT INTO
    dbo.users (
        id,
        username,
        email,
        password,
        full_name,
        role_id,
        role_type
    )
VALUES (
        NEWID(),
        'employee',
        'employee@haomai.com',
        '$2b$10$9L.ZC4sGQ2uiq4boZUKONe96tygh4ZvE3vOPIQ8VLdxaNTwbim9Ae', -- employee123 (hashed)
        'Employee User',
        2,
        'REPOSITOR'
    );

PRINT 'User employee created';

END
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