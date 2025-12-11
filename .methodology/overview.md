# Metodología de Desarrollo Asistido por IA (TDD + Documentación Guiada)

## 1. ¿De qué trata esta metodología?

Esta metodología define **cómo trabajar con una IA como “programador backend asistente”**, de forma **controlada y trazable**.

La idea central es:

- La **IA** se encarga de producir y verificar:
  - **Tests** (TDD, integración, caracterización de legacy).
  - **Código backend** para hacer pasar esos tests.
  - **Documentación técnica** y **diagramas** (PUML, ER, etc.).
- La **persona** (dev/PO/arquitecto) se encarga de:
  - Proveer el **contexto funcional** y las **reglas de negocio**.
  - **Validar** que lo que se hizo es lo correcto para el negocio.
  - Aceptar o corregir el trabajo realizado por la IA.

El foco está en:

- Usar **TDD como pilar**: primero tests que fallen, luego código mínimo para hacerlos pasar.
- Mantener **documentación y artefactos actualizados** en cada tarea.
- Hacer que la IA sea **rápida y consistente**, pero siempre bajo revisión humana.

---

## 2. Objetivos principales

1. **Acelerar el desarrollo** de software backend (especialmente en migración de legacy).
2. Mantener un **alto nivel de control humano** sobre:
   - Qué se desarrolla.
   - Por qué se desarrolla.
   - Si responde realmente a las necesidades de negocio.
3. Convertir a la IA en un **ejecutor disciplinado** de:
   - TDD.
   - Buenas prácticas de backend.
   - Documentación técnica actualizada.
4. Dejar **traza clara** de lo hecho:
   - Tests que cubren los cambios.
   - Diagramas y documentación alineados.
   - Historial diario de modificaciones (`history/walkthrough-DD-MM-AAAA.md`).

---

## 3. Roles: qué hace la IA y qué hace la persona

### IA (Programador backend asistente)

- Trabaja siempre en **español** (prompts y respuestas).
- Se comporta como un **backend developer** disciplinado.
- Su responsabilidad principal es **VERIFICAR**:
  - Escribir y ejecutar tests (TDD, integración, legacy).
  - Escribir el **código mínimo** para que los tests pasen.
  - Mantener **documentación técnica** y **diagramas PUML** al día.
  - Actualizar artefactos clave cuando cambia:
    - La funcionalidad.
    - Los endpoints.
    - El modelo de datos.

### Persona (Dev / PO / Arquitecto)

- Provee el **contexto funcional** del sistema y los módulos:
  - Overview del proyecto.
  - Documentos de módulos.
  - Casos de uso.
  - Reglas de negocio.
  - Requisitos no funcionales.
- Define y asigna la **tarea del tablero kanban**, que debe incluir:
  - Qué se quiere lograr (requisitos funcionales).
  - Qué restricciones hay (requisitos no funcionales).
  - Qué reglas de negocio se deben cumplir.
- Su responsabilidad es **VALIDAR**:
  - Que lo implementado por la IA cumple con lo que el negocio necesita.
  - Que la documentación generada describe correctamente el sistema.

---

## 4. Artefactos clave del proyecto

La metodología se apoya en una serie de **artefactos estándar**, entre otros:

- **Documentos de negocio** (creados por humanos):
  - Overview del proyecto.
  - Módulos del proyecto.
  - Casos de uso y reglas de negocio.
  - Requisitos no funcionales.

- **Documentos técnicos** (creados o mantenidos por la IA + revisados por humanos):
  - Especificación funcional por módulo (qué hace, entradas/salidas).
  - Listado de endpoints por módulo (si aplica).
  - Colecciones Postman/Insomnia por módulo.
  - Diagramas PUML:
    - Diagrama de entidad-relación (modelo de datos).
    - Diagramas de componentes/clases por módulo.
  - Documentación técnica del módulo (tech-doc).
  - Plan de tests inicial por módulo.

- **Historial diario**:
  - `history/walkthrough-DD-MM-AAAA.md`  
    Donde la IA resume los cambios relevantes realizados ese día.

Estos artefactos sirven tanto para que la IA entienda el contexto, como para que el equipo humano pueda seguir y auditar el trabajo.

---

## 5. Flujo de trabajo por TAREA (Kanban)

Cada TAREA en el tablero sigue un flujo estándar:

1. **La persona asigna la TAREA**  
   La tarea debe contener:
   - Requisitos funcionales.
   - Requisitos no funcionales relevantes.
   - Reglas de negocio relacionadas.

2. **Fase TDD – Diseño de tests**
   - La IA, usando:
     - La tarea del kanban.
     - La especificación del módulo.
     - El catálogo de endpoints (si existe).
   - Diseña y escribe tests (unitarios / integración).
   - Ejecuta los tests y confirma que **falla al menos uno**.
   - Si los tests no fallan, los corrige hasta que representen correctamente el comportamiento deseado.

3. **PERIODO DE DESARROLLO**
   - La IA escribe el **código mínimo necesario** para hacer pasar los tests.
   - No agrega lógica ni funcionalidades fuera del alcance de la tarea.
   - Respeta la arquitectura y el stack del proyecto.

4. **PERIODO DE VERIFICACIÓN**
   - La IA ejecuta nuevamente los tests:
     - Nuevos tests.
     - Tests existentes del módulo.
     - Tests legacy de caracterización (si aplica).
   - Si algún test falla, corrige código o tests según corresponda.
   - Puede ejecutar herramientas adicionales (lint, coverage, etc.).

5. **Actualización de artefactos**
   - Si se agregaron o modificaron **endpoints**:
     - Actualiza:
       - **2.2.2** Especificación funcional por módulo.
       - **2.2.3** Endpoints por módulo.
   - Si se crearon nuevas entidades o se cambiaron relaciones de datos:
     - Actualiza:
       - **2.2.4** Diagrama PUML de entidad-relación.
   - Actualiza o crea el archivo:
     - `history/walkthrough-DD-MM-AAAA.md`  
       con un resumen de los cambios más relevantes del día.

6. **Cierre de la TAREA y validación humana**
   - La IA declara la TAREA como **finalizada técnicamente** cuando:
     - Los tests relevantes pasan.
     - Los artefactos están actualizados.
     - El walkthrough del día está escrito/actualizado.
   - Luego, la IA **pide explícitamente al humano que valide**:
     - Si lo desarrollado cumple con los requisitos funcionales.
     - Si respeta reglas de negocio y no funcionales.

Solo después de esa validación humana, la tarea se considera completamente aceptada a nivel de negocio.

---

## 6. Uso con código legacy

Esta metodología es especialmente útil para:

- **Migrar software legacy** a tecnologías más modernas.
- Mantener controlado el riesgo de cambios.

La IA puede:

- Analizar código legacy.
- Generar **tests de caracterización** que describen el comportamiento actual.
- Ayudar a diseñar el nuevo módulo bajo TDD, sin perder las reglas de negocio existentes.
- Documentar el antes y el después mediante:
  - Artefactos técnicos.
  - Diagramas.
  - Walkthrough diarios.

---

## 7. Beneficios esperados

- **Velocidad**: la IA genera código, tests y documentación mucho más rápido.
- **Control**: el humano define el “qué” y valida el resultado final.
- **Trazabilidad**: cada cambio queda cubierto por tests, artefactos actualizados y walkthroughs diarios.
- **Escalabilidad**: el proceso es repetible por módulo y por tarea, incluso con múltiples devs/IA trabajando en paralelo.

Esta metodología no reemplaza al equipo humano: **lo potencia**, transformando a la IA en un colaborador técnico disciplinado y siempre auditado.
