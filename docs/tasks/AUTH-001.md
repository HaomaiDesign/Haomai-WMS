## Task: Implement Authentication & Login

**ID:** AUTH-001
**Status:** Completed
**Priority:** Critical
**Dependencies:** None

### Description
Implementar flujo completo de autenticación (Login) que permita el acceso al sistema. El endpoint de login debe retornar no solo el token JWT sino también la información del usuario y los detalles de la empresa (business) asociada.

### Acceptance Criteria
- [ ] Endpoint `POST /auth/login` implementado.
- [ ] Validación de credenciales (email/password) contra base de datos.
- [ ] Encriptación/Comparación de passwords segura (bcrypt).
- [ ] Generación de JWT- **JWT Payload:** Includes `sub` (User UUID), `username`, and `role`.
- **Response Format:** JSON object containing `access_token`, `role`, `user` (partial object), and `business`.
- **User ID:** Changed from INT to UUID for system scalability and security.- solo id y name.
- [ ] Manejo de errores:
    - [ ] Usuario no encontrado (404/401).
    - [ ] Password incorrecto (401).
    - [ ] Cuenta inactiva/bloqueada (si aplica).
- [ ] Endpoint `GET /auth/profile` o validación de token para recuperar sesión.

### Technical Notes
- Usar NestJS `Passport` + `JWT Strategy`.
- La entidad `User` tiene relación `ManyToOne` con `Business`. Asegurar hacer el `join` o `eager loading` al consultar el usuario.
- El payload del login exitoso debería verse similar a:
  ```json
  {
    "access_token": "ey...",
    "user": {
      "id": 1,
      "email": "...",
      "fullName": "...",
      "role": "ADMIN"
    },
    "business": {
      "id": 1,
      "name": "Haomai Inc"
    }
  }
  ```

### References
- Diagrama ER (Entidades `users` y `business`): `/docs/data-model/DiagramaEntidadRelacion.puml`
- Init SQL (tablas `users`, `business`): `/sql_init/01_create_users_table.sql`, `/sql_init/05_create_business_table.sql`
