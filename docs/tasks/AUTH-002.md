## Task: Implement User Registration (AUTH-002)

**ID:** AUTH-002
**Status:** ToDo
**Priority:** High
**Dependencies:** AUTH-001, BUSINESS-001

### Description
Implementar el endpoint de registro de nuevos usuarios (`/auth/register`). Este endpoint debe ser protegido y exclusivo para usuarios con rol `SUPER_ADMIN`.
El endpoint permitirá crear usuarios administrativos u operativos asignándoles un rol específico.

### Acceptance Criteria
- [ ] Desarrollo de endpoint `POST /auth/register`.
- [ ] Implementar **Guard** para asegurar que solo `SUPER_ADMIN` puede acceder.
- [ ] Validaciones obligatorias:
    - [ ] `email` (formato válido y único).
    - [ ] `username` (único).
    - [ ] `fullName` (nombre y apellido requeridos).
    - [ ] `password` (reglas de complejidad).
    - [ ] `roleType` (debe ser un rol válido del enum: `ADMIN`, `REPOSITOR`, etc.).
- [ ] Creación del usuario en base de datos.
- [ ] Tests Unitarios y E2E para el flujo de registro.

### Technical Notes
- Se ha eliminado el requisito de asociación con `Business`. El usuario se crea a nivel sistema global.


### References
- User Entity: `api/src/modules/users/entities/user.entity.ts`
- AUTH-001 (Login): `docs/tasks/AUTH-001.md`
