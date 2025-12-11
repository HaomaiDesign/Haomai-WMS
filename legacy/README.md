# Configuración de Docker para Proyecto PHP

Este proyecto está configurado para ejecutarse en contenedores Docker, lo que facilita el desarrollo y despliegue.

## Requisitos previos

- Docker
- Docker Compose

## Instrucciones de uso

### Iniciar el entorno de desarrollo

```bash
docker-compose up -d
```

Esto iniciará dos contenedores:
1. Un servidor web Apache con PHP 8.0
2. Un servidor MySQL 5.7

### Acceder a la aplicación

Una vez que los contenedores estén en funcionamiento, puedes acceder a la aplicación en:

```
http://localhost:8080
```

### Conectar a la base de datos

Desde tu código PHP, para conectarte a la base de datos usa los siguientes parámetros:

- **Host**: `db` (el nombre del servicio en docker-compose.yml)
- **Puerto**: `3306` (el puerto estándar de MySQL)
- **Base de datos**: `app_db`
- **Usuario**: `app_user`
- **Contraseña**: `app_password`

Ver el archivo `ejemplo-conexion.php` para un ejemplo completo.

Para conectarte a la base de datos desde fuera del contenedor (por ejemplo, desde MySQL Workbench):

- **Host**: `localhost` o `127.0.0.1`
- **Puerto**: `3306`
- **Usuario, contraseña y base de datos**: igual que arriba

### Detener el entorno

```bash
docker-compose down
```

### Reconstruir el contenedor (después de cambios en el Dockerfile)

```bash
docker-compose up -d --build
```

### Acceder a la línea de comandos del contenedor

```bash
docker-compose exec web bash
```

## Personalización

- Para cambiar la configuración de PHP, modifica las variables de entorno en el archivo `docker-compose.yml`
- Para modificar la configuración de MySQL, ajusta las variables de entorno correspondientes

## Resolución de problemas

### Errores de permisos
Si experimentas problemas de permisos, puedes ejecutar dentro del contenedor:

```bash
chown -R www-data:www-data /var/www/html
``` 