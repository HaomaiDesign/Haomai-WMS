## 2. Artefactos del proyecto

Listado de documentación **esencial** que debe existir antes de comenzar a programar (tests + código), indicando qué hace el **Humano** y qué hace la **IA**.

---

### 2.1 Documentos no técnicos (negocio / producto)

#### 2.1.1 Overview del proyecto
- **Responsable:** 🧑 Humano  
- **Obligatorio:** Sí  
- **Tipo:** No técnico, alto nivel.  
- **Contenido mínimo:**
  - De qué trata el proyecto.
  - Objetivo del proyecto.
  - Quién lo usa (roles).
  - Para qué tareas se usa.
  - Lista resumida de módulos del proyecto (solo nombres + 1 línea de descripción).
- **Uso:** Punto de partida para que la IA y el equipo entiendan el proyecto y propongan módulos.

---

#### 2.1.2 Módulos del proyecto
- **Responsable:** 🤖 IA (borrador) + 🧑 Humano (refina y aprueba)  
- **Obligatorio:** Sí  
- **Tipo:** No técnico / mixto.  
- **Formato sugerido:**
  - Un índice general: `docs/modules/README.md`
  - Un archivo por módulo: `docs/modules/<modulo>/overview.md`
- **Contenido mínimo por módulo:**
  - Nombre del módulo.
  - Descripción corta (qué resuelve).
  - Roles de usuario que lo usan.
  - Relación básica con otros módulos (quién habla con quién).
- **Origen:**  
  - IA lo genera inicialmente a partir del **Overview del proyecto**.  
  - Humano ajusta nombres, descripción y relaciones para que reflejen el negocio real.

---

#### 2.1.3 Casos de uso / User stories por módulo
- **Responsable:** 🧑 Humano  
- **Obligatorio:** No  
- **Tipo:** No técnico, orientado a negocio.  
- **Formato sugerido:** Dentro de `docs/modules/<modulo>/overview.md` o en `use-cases.md`.  
- **Contenido mínimo:**
  - Historias de usuario o casos de uso por módulo.
  - Escenarios felices principales.
  - Escenarios de error relevantes para el negocio.
- **Uso:**  
  - Base para que la IA genere la **especificación funcional** y los tests.

---

#### 2.1.4 Reglas de negocio
- **Responsable:** 🧑 Humano  
- **Obligatorio:** No  (pero se recomienda) 
- **Tipo:** No técnico (pero muy cercano a lo técnico).  
- **Formato sugerido:**  
  - Global: `docs/business-rules.md`  
  - Opcional: sección específica en cada módulo.
- **Contenido mínimo:**
  - Reglas que deben cumplirse sí o sí (validaciones, cálculos, permisos).
  - Qué está prohibido / obligatorio.
- **Uso:**  
  - La IA las usa para diseñar tests y lógica de validación.

---

#### 2.1.5 Requisitos no funcionales (NFR)
- **Responsable:** 🧑 Humano  
- **Obligatorio:** No
- **Tipo:** No técnico / arquitectura.  
- **Formato sugerido:** `docs/non-functional-requirements.md`  
- **Contenido mínimo:**
  - Performance (tiempos máximos, volúmenes).
  - Seguridad (auth, autorizaciones, auditoría).
  - Disponibilidad, resiliencia, logs, etc.
- **Uso:**  
  - Guía para priorizar ciertos tests (límites, carga, etc.) y decisiones técnicas.

---

### 2.2 Documentos técnicos (previos a programar)

#### 2.2.1 Contexto de proyecto
- **Responsable:** 🤖 IA (borrador) + 🧑 Humano (ajusta y aprueba)  
- **Obligatorio:** Sí  
- **Tipo:** Técnico, contextual del proyecto.  
- **Formato sugerido:** `docs/project-context-<stack>.md` (por ejemplo `project-context-node-nestjs.md`).  
- **Contenido mínimo:**
  - Lenguajes, frameworks y librerías principales.
  - Estructura de carpetas estándar.
  - Framework de testing.
  - Comandos de verificación: `npm test`, `npm run lint`, etc.
- **Uso:**  
  - Le dice a la IA **cómo debe trabajar en este repo** (principalmente los comandos de ejecución).
---

#### 2.2.2 Endpoints por módulo (si aplica porque es backend)
- **Responsable:** 🤖 IA
- **Obligatorio:** Sí  
- **Tipo:** Técnico, API.  
- **Formato sugerido:** `docs/modules/<modulo>/endpoints.md`  
- **Contenido mínimo:**
  - Lista de endpoints del módulo:
    - Método HTTP (GET/POST/PUT/DELETE/etc.).
    - Path.
    - Descripción.
    - Request (params, query, body).
    - Response (estructura, códigos HTTP esperados).
- **Origen:**  
  - IA lo construye a partir de:
    - Scraping / análisis del código legacy (si existe).
    - Especificación funcional del módulo.
- **Uso:**  
  - Base para colección Postman.
  - Lo usa el humano para leer más cómodo.

---

#### 2.2.3 Colección Postman
- **Responsable:** 🤖 IA (genera)
- **Obligatorio:** Sí  
- **Tipo:** Técnico, orientado a QA y validación manual.  
- **Formato sugerido:**  
  - `docs/modules/<modulo>/<modulo>-postman.json`  
- **Contenido mínimo:**
  - Un request por endpoint definido.
  - Variables comunes (base URL, tokens de ejemplo).
  - Ejemplos de requests y responses típicos.
- **Origen:**  
  - IA genera la colección a partir del archivo de **endpoints por módulo**.  
- **Uso:**  
  - Utilizado para importar en postman
  - Soporte a tests automatizados de contrato (si se usa).

---

#### 2.2.4 PUML – Diagrama de entidad-relación
- **Responsable:** 🤖 IA
- **Obligatorio:** Sí  
- **Tipo:** Técnico, modelo de datos.  
- **Formato sugerido:** `docs/data-model/er-diagram.puml`  
- **Contenido mínimo:**
  - Entidades/tablas.
  - Relaciones principales (1-1, 1-N, N-N).
  - Atributos clave (IDs, claves foráneas, campos importantes).
- **Origen:**  
  - IA lo genera a partir de:
    - Esquema de base de datos actual (legacy o nuevo).
    - Código de acceso a datos (ORM, migrations, etc.).
- **Uso:**  
  - Referencia para diseño de módulos y endpoints.
  - Ayuda al humano a visualizar el proyecto
---
