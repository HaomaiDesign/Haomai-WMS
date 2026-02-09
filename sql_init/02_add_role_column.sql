-- Add role column to users table
USE haomai_wms;
GO

-- Add role column with default value
-- Valid roles: SUPER_ADMIN, ADMIN, REPOSITOR
ALTER TABLE dbo.users
ADD
role NVARCHAR(50) NOT NULL DEFAULT 'REPOSITOR';
GO

-- Add check constraint for valid roles
ALTER TABLE dbo.users
ADD CONSTRAINT CHK_users_role CHECK (
    role IN (
        'SUPER_ADMIN',
        'ADMIN',
        'REPOSITOR'
    )
);
GO

-- Create index for better query performance
CREATE INDEX idx_users_role ON dbo.users ( role );
GO

-- Update existing users with specific roles
UPDATE dbo.users SET role = 'ADMIN' WHERE username = 'admin';

UPDATE dbo.users SET role = 'REPOSITOR' WHERE username = 'employee';
GO

PRINT 'Role column added successfully with SUPER_ADMIN, ADMIN, REPOSITOR roles';