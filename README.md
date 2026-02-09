# Haomai WMS - Sistema de Gestión de Depósito

Sistema moderno de gestión de almacén (Warehouse Management System) construido con NestJS, Next.js y SQL Server.

## 📋 Stack Tecnológico

- **Backend**: NestJS 11.x + TypeORM + TypeScript
- **Frontend**: Next.js 16.x + TailwindCSS + TypeScript
- **Base de Datos**: SQL Server 2022 Developer
- **Orquestación**: Docker Compose
- **Testing**: Jest + Supertest

---

## 🚀 Inicio Rápido

### Prerrequisitos

- Docker y Docker Compose instalados
- Node.js 20+ (para desarrollo local sin Docker)
- pnpm (para backend) / npm (para frontend)

### Levantar el Entorno Completo

```bash
# 1. Clonar el repositorio
git clone <repository-url>
cd Haomai-WMS

# 2. Copiar archivos de ejemplo de variables de entorno
cp backend/api/.env.example backend/api/.env

# 3. Levantar todos los servicios con Docker Compose
docker compose up -d

# 4. Inicializar la base de datos (primera vez solamente)
docker exec -it haomai_wms_db /opt/mssql-tools/bin/sqlcmd -S localhost -U sa -P 'HaomaiWMS2024!' -i /docker-entrypoint-initdb.d/01_create_users_table.sql

# 5. Ver logs
docker compose logs -f
```

### Servicios Disponibles

| Servicio | URL | Descripción |
|----------|-----|-------------|
| Frontend | http://localhost:3000 | Aplicación Next.js |
| Backend API | http://localhost:3001 | API REST NestJS |
| Base de Datos | localhost:1433 | SQL Server |

### Credenciales de Base de Datos

```
Host: localhost
Port: 1433
User: sa
Password: HaomaiWMS2024!
Database: haomai_wms
```

---

## 🔧 Desarrollo Local (Sin Docker)

### Backend

```bash
cd backend/api

# Instalar dependencias
pnpm install

# Copiar variables de entorno
cp .env.example .env

# Asegurarse de que SQL Server está corriendo
# Actualizar .env con las credenciales correctas

# Modo desarrollo con hot-reload
pnpm run start:dev

# Ejecutar tests
pnpm test

# Tests E2E
pnpm test:e2e

# Linter
pnpm run lint

# Build
pnpm run build
```

### Frontend

```bash
cd backend/web

# Instalar dependencias
npm install

# Modo desarrollo
npm run dev

# Build
npm run build

# Lint
npm run lint
```

---

## 📂 Estructura del Proyecto

```
Haomai-WMS/
├── backend/
│   ├── api/                    # NestJS Backend
│   │   ├── src/
│   │   │   ├── config/        # Configuraciones
│   │   │   ├── modules/       # Módulos de negocio
│   │   │   │   └── users/     # Módulo de usuarios
│   │   │   ├── app.module.ts
│   │   │   └── main.ts
│   │   ├── test/              # Tests E2E
│   │   ├── Dockerfile
│   │   └── package.json
│   │
│   └── web/                    # Next.js Frontend
│       ├── src/
│       │   └── app/           # App Router
│       ├── public/
│       ├── Dockerfile
│       └── package.json
│
├── docs/                       # Documentación
├── history/                    # Walkthroughs diarios
├── legacy/                     # Código PHP legacy (referencia)
├── sql_init/                   # Scripts SQL de inicialización
├── docker-compose.yml
└── README.md
```

---

## 🧪 Testing

El proyecto sigue metodología **TDD (Test-Driven Development)**:

1. Escribir tests que fallen
2. Escribir código mínimo para hacerlos pasar
3. Refactorizar

### Ejecutar Tests

```bash
# Backend - Tests unitarios
cd backend/api
pnpm test

# Backend - Tests E2E
pnpm test:e2e

# Backend - Coverage
pnpm test:cov

# Frontend - Tests
cd backend/web
npm test
```

---

## 📊 Módulos del Sistema

### Implementados

- ✅ **Users**: Gestión de usuarios del sistema

### Planificados

- 📝 **Pedidos y Movimientos**: Ingresos y egresos de mercadería
- 📝 **Logística**: Pedidos de distribución y entregas
- 📝 **Depósito**: Inventario, productos y ubicaciones
- 📝 **Clientes**: Gestión de clientes
- 📝 **Reportes**: Métricas y análisis

---

## 🗄️ Base de Datos

### Tablas Implementadas

- `users`: Usuarios del sistema con roles y permisos

### Conexión Manual

```bash
# Desde el host
sqlcmd -S localhost,1433 -U sa -P 'HaomaiWMS2024!' -d haomai_wms

# Desde el contenedor
docker exec -it haomai_wms_db /opt/mssql-tools/bin/sqlcmd -S localhost -U sa -P 'HaomaiWMS2024!' -d haomai_wms
```

---

## 🔄 Comandos Útiles de Docker

```bash
# Levantar servicios
docker compose up -d

# Ver logs
docker compose logs -f [service_name]

# Detener servicios
docker compose down

# Detener y eliminar volúmenes (⚠️ borra datos)
docker compose down -v

# Rebuild de imágenes
docker compose build --no-cache

# Reiniciar un servicio específico
docker compose restart api

# Ver estado de servicios
docker compose ps

# Ejecutar comando en contenedor
docker exec -it haomai_wms_api sh
```

---

## 📝 Variables de Entorno

### Backend (.env)

```env
# Database
DATABASE_HOST=localhost
DATABASE_PORT=1433
DATABASE_USER=sa
DATABASE_PASSWORD=HaomaiWMS2024!
DATABASE_NAME=haomai_wms

# Application
NODE_ENV=development
PORT=3001

# JWT (futuro)
JWT_SECRET=your-secret-key
JWT_EXPIRES_IN=1d
```

### Frontend (.env.local)

```env
NEXT_PUBLIC_API_URL=http://localhost:3001
```

---

## 📖 Metodología

Este proyecto sigue la **Metodología de Desarrollo Asistido por IA con TDD**.

Ver: [`.methodology/overview.md`](file:///.methodology/overview.md)

Principios clave:
- **TDD obligatorio**: Tests primero, código después
- **Documentación actualizada**: Artefactos sincronizados con el código
- **Código en inglés**, documentación en español
- **Validación humana** de requisitos de negocio

---

## 🤝 Contribución

1. Leer la metodología en `.methodology/`
2. Seguir el flujo TDD
3. Actualizar artefactos correspondientes
4. Crear/actualizar walkthrough diario

---

## 📄 Licencia

Propietario: Haomai

---

## 📞 Contacto

Para más información, consultar la documentación en `docs/`.
