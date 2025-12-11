# Módulo: Pedidos y Movimientos

## Descripción
Este módulo centraliza la gestión operativa de entrada y salida de mercadería del depósito. Su objetivo principal es asegurar la trazabilidad de los productos, gestionando lotes, vencimientos y la asociación de movimientos con pedidos específicos.

## Funcionalidades Principales
- **Pedidos:** Visualización y gestión de órdenes de ingreso y egreso.
- **Ingreso de Mercadería:**
  - Registro de entrada de productos.
  - Uso de escáner de códigos de barra.
  - Asignación de depósito y lote.
  - Definición de fechas de vencimiento.
- **Egreso de Mercadería:**
  - Registro de salida de productos.
  - Selección de lote específico a egresar (FIFO/FEFO support).
  - Asociación del movimiento a un pedido o cliente existente.

## Roles de Usuario
- **Empleado de Depósito:** Realiza la carga física y el escaneo de productos.
- **Administrador:** Supervisa los movimientos y gestiona correcciones si es necesario.

## Relación con otros módulos
- **Depósito:** Cada movimiento (ingreso/egreso) actualiza inmediatamente la disponibilidad y el stock en el módulo de Depósito.
- **Logística:** Los pedidos preparados y egresados alimentan el flujo de entregas en el módulo de Logística.
- **Clientes:** Los egresos suelen estar vinculados a un cliente destinatario.
