# Módulo: Depósito

## Descripción
Es el corazón del sistema WMS, responsable de mantener el estado actual y real del inventario. Ofrece una visión detallada de qué productos hay, dónde están y cuál es su historial, permitiendo una administración eficiente del espacio físico y del capital inmovilizado.

## Funcionalidades Principales
- **Lista de Productos:** Catálogo maestro de productos gestionados.
- **Disponibilidad:** Consulta en tiempo real de stock por SKU, lote y ubicación.
- **Registros:** Historial completo y auditable de todos los movimientos de inventario (quién movió qué y cuándo).
- **Ubicación:** Gestión de mapas de depósito, racks, estanterías y posiciones (slots).

## Roles de Usuario
- **Empleado de Depósito:** Consulta ubicaciones para guardar o buscar mercadería.
- **Administrador:** Gestiona la configuración del depósito y audita diferencias de stock.
- **Gerente:** Consulta disponibilidad para decisiones de compra o venta.

## Relación con otros módulos
- **Pedidos y Movimientos:** Es alimentado por las transacciones de este módulo; cualquier ingreso o egreso impacta aquí.
- **Reportes:** Provee la data cruda para la generación de métricas y alertas de stock.
