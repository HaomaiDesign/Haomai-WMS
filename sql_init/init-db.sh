#!/bin/bash

# Wait for SQL Server to start
echo "Waiting for SQL Server to start..."
sleep 30s

# Run the initialization scripts
echo "Running SQL initialization scripts..."
for file in /docker-entrypoint-initdb.d/*.sql; do
    if [ -f "$file" ]; then
        echo "Executing $file"
        /opt/mssql-tools/bin/sqlcmd -S localhost -U sa -P $SA_PASSWORD -d master -i "$file"
    fi
done

echo "Database initialization complete!"
