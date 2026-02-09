-- SQL Server migration script for Haomai WMS
-- Table: business
-- Migration: 05_create_business_table.sql

USE haomai_wms;
GO

-- Create business table if not exists
IF OBJECT_ID('dbo.business', 'U') IS NULL BEGIN
CREATE TABLE dbo.business (
    id INT IDENTITY(1, 1) PRIMARY KEY,
    business_name NVARCHAR(1000) NULL,
    legal_name NVARCHAR(1000) NULL,
    logo NVARCHAR(1000) NULL,
    tax_id NVARCHAR(1000) NULL,
    phone NVARCHAR(1000) NULL,
    whatsapp NVARCHAR(1000) NULL,
    wechat NVARCHAR(1000) NULL,
    web_page NVARCHAR(1000) NULL,
    email NVARCHAR(1000) NULL,
    address NVARCHAR(1000) NULL,
    postal_code NVARCHAR(1000) NULL,
    location NVARCHAR(1000) NULL,
    province NVARCHAR(1000) NULL,
    country NVARCHAR(1000) NULL,
    category NVARCHAR(1000) NULL,
    tax_condition NVARCHAR(1000) NULL,
    description NVARCHAR(MAX) NULL,
    subscription INT NULL DEFAULT 0,
    registration_date DATE NULL DEFAULT GETDATE(),
    created_at DATETIME2 DEFAULT GETDATE(),
    updated_at DATETIME2 DEFAULT GETDATE()
);

PRINT 'Table dbo.business created successfully';

END ELSE BEGIN PRINT 'Table dbo.business already exists, skipping creation';

END

-- Create indexes for better performance
IF NOT EXISTS (
    SELECT *
    FROM sys.indexes
    WHERE
        name = 'idx_business_tax_id'
        AND object_id = OBJECT_ID('dbo.business')
) BEGIN CREATE
INDEX idx_business_tax_id ON dbo.business (tax_id);

PRINT 'Index idx_business_tax_id created';

END

IF NOT EXISTS (
    SELECT *
    FROM sys.indexes
    WHERE
        name = 'idx_business_email'
        AND object_id = OBJECT_ID('dbo.business')
) BEGIN CREATE
INDEX idx_business_email ON dbo.business (email);

PRINT 'Index idx_business_email created';

END

-- Add FK constraint to users table if not exists
IF NOT EXISTS (
    SELECT *
    FROM sys.foreign_keys
    WHERE
        name = 'FK_users_business'
        AND parent_object_id = OBJECT_ID('dbo.users')
) BEGIN
ALTER TABLE dbo.users
ADD CONSTRAINT FK_users_business FOREIGN KEY (business_id) REFERENCES dbo.business (id);

PRINT 'Foreign key FK_users_business added to users table';

END

PRINT 'Migration 05_create_business_table completed successfully';