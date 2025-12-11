# Overview - Haomai WMS

## Introducción

El proyecto es un sistema de gestión de depósito (WMS), gestión de ingreso y egreso de stock, con funcionalidades agregadas como generación de reportes, métricas, logística, registro de movimientos de los usuarios (logs), acciones basadas en roles (adminsitrador, empleado, etc). Este sistema le pertenece a Haomai

## Objetivo del proyecto

El sistema está pensado para que pueda ser deployeable para nuevos clientes en no mas de 48hs, reutilizando el proyecto base, configurable fácilmente (a través de un solo archivo) todas las credenciales necesarias para un nuevo cliente (todos los datos necesarios de la empresa). Además debe permitir llevar un registro de todos los ingresos y egresos, y tener un stock al día.

## ¿Quién usa el sistema?

El sistema es para el personal de la empresa, que puede ser empleado, administrador, un gerente de ventas.

## ¿Para qué tareas se usa el sistema?

- Gestión de stock
- Gestión de ingresos y egresos
- Generación de reportes
- Métricas. Rendimientos de productos. Inventario bajo.
- Logística
- Registro de movimientos de los usuarios (logs)

## Módulos del proyecto

- **Pedidos y Movimientos**: Gestión de ingresos y egresos de mercadería ("Ingreso de Mercadería", "Egreso de Mercadería").
- **Logística**: Gestión de pedidos de distribución/venta y entregas ("Pedidos", "Entrega").
- **Depósito**: Administración de inventario, incluyendo lista de productos, disponibilidad, registros y gestión de ubicaciones.
- **Clientes**: Gestión y listado de clientes.
- **Reportes**: Visualización de métricas, reportes por categoría, vencimientos, alertas de inventario bajo y movimientos de stock.