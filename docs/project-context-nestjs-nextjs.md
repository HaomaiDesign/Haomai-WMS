# Contexto del Proyecto: NestJS + NextJS

Este documento define el stack tecnológico, la estructura del proyecto y los comandos estándar para el desarrollo asistido por IA.

## 1. Stack Tecnológico

- **Lenguaje Principal:** TypeScript
- **Backend Framework:** NestJS (Node.js)
- **Frontend Framework:** Next.js (React)
- **Estilos:** TailwindCSS
- **Base de Datos:** SQLServer (según documentación existente), gestionada vía TypeORM o Prisma (a definir).
- **Entorno:** Docker / Docker Compose

## 2. Estructura de Carpetas

El proyecto sigue una estructura de monorepo (o separación clara de responsabilidades):

```text
/
├── backend/
│   ├── .env            # Variables de entorno compartidas
│   ├── .gitignore
│   ├── README.md
│   ├── api/            # Backend (NestJS)
│   │   ├── src/
│   │   │   ├── [module]/
│   │   │   │   ├── dto/
│   │   │   │   ├── entities/
│   │   │   │   ├── *.controller.ts
│   │   │   │   ├── *.module.ts
│   │   │   │   └── *.service.ts
│   │   │   ├── app.controller.ts
│   │   │   ├── app.module.ts
│   │   │   ├── app.service.ts
│   │   │   └── main.ts
│   │   └── test/
│   └── web/            # Frontend (NextJS)
           ├── src/
           │   ├── api/
           │   ├── components/
           │   ├── contexts/
           │   ├── hooks/
           │   ├── pages/
           │   ├── styles/
           │   ├── types/
           │   └── utils/
           ├── public/
           ├── .env
           ├── next.config.js
           ├── package.json
           └── tsconfig.json
├── docs/               # Documentación del proyecto
├── legacy/             # Código base anterior (PHP) para referencia
├── docker-compose.yml  # Orquestación de servicios
└── package.json        # Dependencias raíz (si aplica monorepo)
```

### Convenciones Backend (NestJS)
**Importante:** La estructura inicial y los recursos deben generarse utilizando **Nest CLI** (`nest new`, `nest g resource`, etc.). No crear la estructura de carpetas manualmente.

- `src/`: Directorio fuente generado por NestJS.
- `src/modules/`: Módulos de dominio (e.g., `orders`, `users`).
- Estructura por módulo:
  - `dto/`
  - `entities/`
  - `*.controller.ts`
  - `*.service.ts`
  - `*.module.ts`

### Convenciones Frontend (NextJS)
- `src/pages/`: Pages Router (rutas y vistas).
- `src/components/`: Componentes visuales reutilizables.
- `src/contexts/`: Estado global (React Context).
- `src/hooks/`: Custom hooks.
- `src/utils/` y `src/api/`: Lógica de negocio y clientes HTTP.
- `src/styles/`: Archivos de estilos (Tailwind/CSS modules).


## 3. Framework de Testing

- **Unitarios/Integración:** Jest
- **E2E:** Supertest (Backend), Playwright/Cypress (Frontend - opcional)

## 4. Comandos de Verificación

La IA debe utilizar estos comandos para validar sus cambios antes de solicitar revisión humana.

### Backend (en `apps/api`)
- **Tests Unitarios:** `npm run test`
- **Tests E2E:** `npm run test:e2e`
- **Linter:** `npm run lint`
- **Build:** `npm run build`

### Frontend (en `apps/web`)
- **Tests:** `npm run test`
- **Linter:** `npm run lint`
- **Build:** `npm run build`

### Global
- **Levantar entorno:** `docker-compose up -d`
