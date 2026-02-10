## Task: Remove Business Entity (BUSINESS-001)

**ID:** BUSINESS-001
**Status:** ToDo
**Priority:** Critical
**Dependencies:** None

### Description
Revertir la existencia de la entidad **`Business`**. El sistema pasará a ser de instancia única (Single Tenant) o gestión global, eliminando la necesidad de asociar datos a un "Negocio" específico.
Esto implica eliminar la tabla `business`, todas las claves foráneas `business_id` en el modelo de datos, y el código relacionado en el Backend.

### Acceptance Criteria
- [ ] **Base de Datos**:
    - [ ] Eliminar tabla `dbo.business`.
    - [ ] Eliminar columna `business_id` y constraints FK de TODAS las tablas (`users`, `products`, `warehouse`, `orders`, etc.).
    - [ ] Actualizar scripts de migración:
        - [ ] Eliminar `03_create_business_table.sql`.
        - [ ] Actualizar `04_create_wms_model.sql` para remover referencias a business.
        - [ ] Actualizar `05_base_client_data.sql` para no insertar business.
- [ ] **Backend (API)**:
    - [ ] Eliminar `BusinessModule` y `Business` entity.
    - [ ] Actualizar `User` entity (eliminar `businessId` y relación).
    - [ ] Actualizar `AuthService` (eliminar `business` del login response).
    - [ ] Eliminar referencias a `businessId` en todos los servicios y repositorios.
- [ ] **Tests**:
    - [ ] Actualizar/Eliminar tests que dependan de Business.

### Technical Notes
- Este es un refactor destructivo masivo.
- Se debe asegurar que la aplicación levante correctamente sin el módulo de Business.

### References
- `api/src/modules/business/*`
- `sql_init/*`
