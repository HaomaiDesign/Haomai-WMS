-- Add role_type column to users table
USE haomai_wms;
GO

PRINT 'Starting 02_add_role_column.sql execution';
GO

-- 1. Add role_type column
IF COL_LENGTH('dbo.users', 'role_type') IS NULL BEGIN PRINT 'Adding role_type column...';

ALTER TABLE dbo.users
ADD role_type NVARCHAR(50) NOT NULL DEFAULT 'REPOSITOR';

PRINT 'Column role_type added.';

END ELSE BEGIN PRINT 'Column role_type already exists.';

END

-- 2. Add CHK_users_role_type using Dynamic SQL
-- Using sp_executesql to defer compilation so it doesn't fail if column doesn't exist at batch start
IF OBJECT_ID('CHK_users_role_type', 'C') IS NULL BEGIN PRINT 'Adding constraint CHK_users_role_type...';

DECLARE @sql NVARCHAR(MAX);
    SET @sql = N'ALTER TABLE dbo.users ADD CONSTRAINT CHK_users_role_type CHECK (role_type IN (''SUPER_ADMIN'', ''ADMIN'', ''REPOSITOR''))';
    EXEC sp_executesql @sql;
    PRINT 'Constraint CHK_users_role_type added';
END

ELSE BEGIN PRINT 'Constraint CHK_users_role_type already exists.';

END

-- 3. Create idx_users_role_type using Dynamic SQL
IF NOT EXISTS (
    SELECT *
    FROM sys.indexes
    WHERE
        name = 'idx_users_role_type'
        AND object_id = OBJECT_ID('dbo.users')
) BEGIN PRINT 'Creating index idx_users_role_type...';

DECLARE @sqlIndex NVARCHAR(MAX);
    SET @sqlIndex = N'CREATE INDEX idx_users_role_type ON dbo.users (role_type)';
    EXEC sp_executesql @sqlIndex;
    PRINT 'Index idx_users_role_type created';
END

ELSE BEGIN PRINT 'Index idx_users_role_type already exists.';

END

PRINT '02_add_role_column.sql completed successfully';