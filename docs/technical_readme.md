# Haomai WMS - Technical Documentation

This document provides technical instructions for developers working on the Haomai WMS project.

## Running Tests in Docker

To run tests, ensure that the Docker containers are up and running:

```bash
docker compose up -d
```

### Unit Tests

Run the unit test suite for the API service:

```bash
docker compose exec api npm run test
```

### Watch Mode (Development)

Run tests in watch mode to automatically re-run on file changes:

```bash
docker compose exec api npm run test:watch
```

### E2E Tests (End-to-End)

Run the end-to-end integration tests:

```bash
docker compose exec api npm run test:e2e
```

### Test Coverage

Generate a test coverage report:

```bash
docker compose exec api npm run test:cov
```

## Database Management

### Connect to SQL Server

To connect to the database container using `sqlcmd` (useful for quick queries):

```bash
docker compose exec db /opt/mssql-tools/bin/sqlcmd -S localhost -U sa -P 'S4DMHaomai!' -d haomai_wms
```

### Reset Database

To completely reset the database (WARNING: Deletes all data):

```bash
docker compose down -v
docker compose up -d --build
```
