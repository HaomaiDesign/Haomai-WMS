-- Update passwords with bcrypt hashes and add super admin user
USE haomai_wms;
GO

-- Insert super admin user
-- Password: S4DMHaomai!
INSERT INTO
    dbo.users (
        username,
        email,
        password,
        full_name,
        role_id,
        business_id,
        role
    )
VALUES (
        'superadmin',
        'superadmin@haomai.com',
        '$2b$10$ZrWWwW0G3najeXoAZnBh/OAnhg/Z6.H2OZjJK1j98IjXtrqflVW7C', -- S4DMHaomai!
        'Super Administrator',
        1,
        1,
        'SUPER_ADMIN'
    );
GO

-- Update passwords with proper bcrypt hashes
UPDATE dbo.users
SET
    password = '$2b$10$vhD2lOkAwgcT38dSm/HToeeR3LCLlKxUn1Uor/zErTc7T/pLlcTLG'
WHERE
    username = 'admin';

UPDATE dbo.users
SET
    password = '$2b$10$9L.ZC4sGQ2uiq4boZUKONe96tygh4ZvE3vOPIQ8VLdxaNTwbim9Ae'
WHERE
    username = 'employee';

-- Password already set during INSERT, no need to update
GO
GO

PRINT 'Passwords hashed successfully';

PRINT 'Credentials:';

PRINT ' superadmin / S4DMHaomai!';

PRINT ' admin / admin123';

PRINT ' employee / employee123';