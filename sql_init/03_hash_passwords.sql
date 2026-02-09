-- Update passwords with bcrypt hashes
USE haomai_wms;
GO

UPDATE dbo.users 
SET password = '$2b$10$vhD2lOkAwg cT38dSm/HToeeR3LCLlKxUn1Uor/zErTc7T/pLlcTLG'
WHERE username = 'admin';

UPDATE dbo.users
SET password = '$2b$10$9L.ZC4sGQ2uiq4boZUKONe96tygh4ZvE3vOPIQ8VLdxaNTwbim9Ae'
WHERE username = 'employee';
GO

PRINT 'Passwords hashed successfully';
PRINT 'Credentials:';
PRINT '  admin / admin123';
PRINT '  employee / employee123';
