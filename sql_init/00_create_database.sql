-- Create database if it does not exist
IF NOT EXISTS (
    SELECT *
    FROM sys.databases
    WHERE
        name = 'haomai_wms'
) BEGIN CREATE
DATABASE haomai_wms;

PRINT 'Database haomai_wms created successfully';

END ELSE BEGIN PRINT 'Database haomai_wms already exists';

END