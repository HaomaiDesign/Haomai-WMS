#!/bin/bash

# Start SQL Server in the background
/opt/mssql/bin/sqlservr &

# Wait for SQL Server to be ready
echo "Waiting for SQL Server to start..."
for i in {1..60}; do
    /opt/mssql-tools18/bin/sqlcmd -S localhost -U sa -P "$SA_PASSWORD" -C -Q "SELECT 1" > /dev/null 2>&1
    if [ $? -eq 0 ]; then
        echo "SQL Server is ready!"
        break
    fi
    echo "Attempt $i/60 - SQL Server not ready yet..."
    sleep 2
done

# Run the initialization scripts in order
echo "Running SQL initialization scripts..."
for file in /docker-entrypoint-initdb.d/*.sql; do
    if [ -f "$file" ]; then
        echo "Executing $file ..."
        /opt/mssql-tools18/bin/sqlcmd -S localhost -U sa -P "$SA_PASSWORD" -C -i "$file"
        if [ $? -ne 0 ]; then
            echo "ERROR: Failed to execute $file"
        else
            echo "SUCCESS: $file executed"
        fi
    fi
done

echo "========================================="
echo "Database initialization complete!"
echo "========================================="

# Keep the container running by waiting on the SQL Server process
wait
