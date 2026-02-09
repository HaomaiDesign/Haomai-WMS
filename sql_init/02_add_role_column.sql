-- Add role column to users table
USE haomai_wms;
GO

-- Add role column with default value
ALTER TABLE dbo.users 
ADD role NVARCHAR(50) NOT NULL DEFAULT 'REPOSITOR';
GO

-- Create index for better query performance
CREATE INDEX idx_users_role ON dbo.users(role);
GO

-- Update existing users with specific roles
UPDATE dbo.users SET role = 'ADMIN' WHERE username = 'admin';
UPDATE dbo.users SET role = 'REPOSITOR' WHERE username = 'employee';
GO

PRINT 'Role column added successfully';
