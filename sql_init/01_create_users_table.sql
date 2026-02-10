-- SQL Server initialization script for Haomai WMS
-- Table: users

USE haomai_wms;
GO

-- Create users table if not exists
IF OBJECT_ID('dbo.users', 'U') IS NULL BEGIN
CREATE TABLE dbo.users (
    id UNIQUEIDENTIFIER DEFAULT NEWID() PRIMARY KEY,
    username NVARCHAR(255) NULL,
    email NVARCHAR(255) NULL,
    password NVARCHAR(1000) NULL,
    full_name NVARCHAR(1000) NULL,
    personal_id NVARCHAR(1000) NULL,
    role_id INT NULL,
    job_title NVARCHAR(1000) NULL,
    department NVARCHAR(1000) NULL,
    address NVARCHAR(1000) NULL,
    postal_code NVARCHAR(1000) NULL,
    location NVARCHAR(1000) NULL,
    province NVARCHAR(1000) NULL,
    country NVARCHAR(1000) NULL,
    phone NVARCHAR(1000) NULL,
    mobile NVARCHAR(1000) NULL,
    avatar NVARCHAR(1000) NULL,
    language_id INT NULL,
    registration_date DATE NULL,
    last_login DATE NULL,
    whatsapp NVARCHAR(1000) NULL,
    wechat NVARCHAR(1000) NULL,
    tax_id NVARCHAR(1000) NULL,
    description NVARCHAR(1000) NULL,
    flag_email_checked BIT NULL DEFAULT 0,
    flag_reset_password BIT NULL DEFAULT 0,
    created_at DATETIME2 DEFAULT GETDATE(),
    updated_at DATETIME2 DEFAULT GETDATE()
);

-- Create indexes for better performance
CREATE INDEX idx_users_email ON dbo.users (email);

CREATE INDEX idx_users_username ON dbo.users (username);

PRINT 'Users table created successfully';

END ELSE BEGIN PRINT 'Users table already exists, skipping creation';

END