-- SQL Server initialization script for Haomai WMS
-- Table: users

-- Create database if not exists
IF NOT EXISTS (SELECT * FROM sys.databases WHERE name = 'haomai_wms')
BEGIN
    CREATE DATABASE haomai_wms;
END
GO

USE haomai_wms;
GO

-- Drop table if exists
IF OBJECT_ID('dbo.users', 'U') IS NOT NULL
    DROP TABLE dbo.users;
GO

-- Create users table
CREATE TABLE dbo.users (
    id INT IDENTITY(1,1) PRIMARY KEY,
    username NVARCHAR(1000) NULL,
    email NVARCHAR(1000) NULL,
    password NVARCHAR(1000) NULL,
    full_name NVARCHAR(1000) NULL,
    personal_id NVARCHAR(1000) NULL,
    business_id INT NULL,
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
GO

-- Create indexes for better performance
CREATE INDEX idx_users_email ON dbo.users(email);
CREATE INDEX idx_users_username ON dbo.users(username);
CREATE INDEX idx_users_business_id ON dbo.users(business_id);
GO

-- Insert sample data for testing
INSERT INTO dbo.users (username, email, password, full_name, role_id, business_id)
VALUES 
    ('admin', 'admin@haomai.com', '$2b$10$XYZ...', 'Administrator', 1, 1),
    ('employee', 'employee@haomai.com', '$2b$10$ABC...', 'Employee User', 2, 1);
GO

PRINT 'Users table created successfully';
