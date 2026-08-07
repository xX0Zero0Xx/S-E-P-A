# S.E.P.A

Sistema web desarrollado con Laravel para simular el proceso de captura de un pedimento aduanal en un entorno educativo y de capacitación.

## Descripción

SEPA es una aplicación orientada a la práctica y el aprendizaje del flujo operativo asociado a la declaración aduanera en comercio exterior. El proyecto permite explorar, de forma controlada, la captura de información comercial, arancelaria y documental que normalmente forma parte de un pedimento aduanal.

El objetivo principal es ofrecer un entorno de aprendizaje para estudiantes, docentes y desarrolladores que deseen comprender el proceso de despacho aduanero sin interactuar con sistemas oficiales ni generar documentos con validez legal.

## ¿Qué es un pedimento aduanal?

Un pedimento aduanal es el documento oficial con el que una operación de importación o exportación se declara ante la autoridad aduanera. En él se registran datos clave relacionados con:

- Importador y exportador
- Agente o agencia aduanal
- Régimen aduanero aplicable
- Fracción arancelaria
- Descripción, cantidad y valor de las mercancías
- Contribuciones y aprovechamientos
- Información de transporte y aduana
- Documentos anexos como facturas, COVE y certificados de origen

> Nota: este proyecto es un simulador académico. No se conecta con servicios oficiales de la Agencia Nacional de Aduanas de México (ANAM) ni genera documentos con valor legal.

## Tecnologías utilizadas

- PHP 8.4
- Laravel 12
- MySQL
- Node.js
- Composer
- Docker & Docker Compose

---

## Instalación

Elige la guía de instalación según tu entorno:

- [Opción A: Instalación Local](#opción-a-instalación-local)
- [Opción B: Instalación con Docker](#opción-b-instalación-con-docker)

---

## Opción A: Instalación Local

### Requisitos previos

Asegúrate de tener instalados:

- PHP 8.4+
- Composer
- Node.js y npm
- MySQL Server
- Git

> Repositorio recomendado para preparar el entorno de desarrollo: [Dev-Setup](https://github.com/xX0Zero0Xx/Dev-Setup.git)

### 1. Clonar el repositorio

```bash
git clone https://github.com/xX0Zero0Xx/S-E-P-A.git
cd S-E-P-A
```

### 2. Crear la base de datos

Accede a la consola de MySQL y ejecuta:

```sql
CREATE DATABASE DB_Ejemplo;
CREATE USER 'Usuario_Ejemplo'@'%' IDENTIFIED BY 'Password_Ejemplo';
GRANT ALL PRIVILEGES ON DB_Ejemplo.* TO 'Usuario_Ejemplo'@'localhost';
FLUSH PRIVILEGES;
```

### 3. Configurar variables de entorno

```bash
cp .env.example .env
```

Edita el archivo `.env` y configura la conexión a la base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=DB_Ejemplo
DB_USERNAME=Usuario_Ejemplo
DB_PASSWORD=Password_Ejemplo
```

### 4. Instalar dependencias

```bash
composer install
npm install
```

### 5. Generar clave de la aplicación y configurar permisos

```bash
php artisan key:generate
php artisan config:clear

# Crear directorios si faltan y dar permisos de escritura
mkdir -p storage/framework/views storage/framework/cache storage/framework/sessions
chmod -R 775 storage bootstrap/cache
```

### 6. Ejecutar migraciones y seeders

```bash
php artisan migrate
php artisan db:seed
```

### 7. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

La aplicación estará disponible en:

```
http://127.0.0.1:8000
```

---

## Opción B: Instalación con Docker

Esta opción levanta dos contenedores gestionados mediante Docker Compose:

| Contenedor | Servicio | Descripción |
|---|---|---|
| `SEPA_DB` | MySQL 8.0 | Base de datos (oculta, sin puertos expuestos) |
| `SEPA_web` | Apache2 + PHP 8.4 | Servidor web con Laravel |

> **Nota de seguridad:** El contenedor `SEPA_DB` no expone puertos al exterior. Solo es accesible desde `SEPA_web` a través de la red interna de Docker (`sepa_network`).

### Requisitos previos

- Docker
- Docker Compose

### 1. Clonar el repositorio

```bash
git clone https://github.com/xX0Zero0Xx/S-E-P-A.git
cd S-E-P-A
```

### 2. Configurar variables de entorno

```bash
cp .env.example .env
```

Edita el archivo `.env` y configura la conexión a la base de datos para Docker:

```env
DB_CONNECTION=mysql
DB_HOST=SEPA_DB
DB_PORT=3306
DB_DATABASE=sepa_db
DB_USERNAME=sepa_user
DB_PASSWORD=sepa_password_seguro
```

> **Importante:** El valor de `DB_HOST` debe ser `SEPA_DB` (el nombre del contenedor de base de datos dentro de la red Docker), no `127.0.0.1`.

### 3. Construir e iniciar los contenedores

```bash
docker-compose up -d --build
```

Verifica que ambos contenedores estén corriendo:

```bash
docker-compose ps
```

Deberías ver algo similar a:

```
  Name       Image              Status         Ports
SEPA_web   s-e-p-a_sepa_web   Up             0.0.0.0:8080->80/tcp
SEPA_DB    mysql:8.0          Up             3306/tcp (solo interno)
```

### 4. Configurar permisos de almacenamiento (Evitar error de compilación de Blade/tempnam)

Si obtienes errores relacionados con la escritura de vistas compiladas de Blade o archivos temporales (`tempnam()`), ejecuta:

```bash
docker exec -it SEPA_web bash -c "mkdir -p storage/framework/views storage/framework/cache storage/framework/sessions && chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache && php artisan view:clear"
```

### 5. Ejecutar migraciones y seeders

```bash
docker exec SEPA_web php artisan migrate --force
docker exec SEPA_web php artisan db:seed --force
```

### 6. Acceder a la aplicación

La aplicación estará disponible en:

```
http://localhost:8080
```

### Comandos útiles de Docker

```bash
# Detener los contenedores
docker-compose down

# Detener y eliminar volúmenes (reinicia la base de datos)
docker-compose down -v

# Ver logs en tiempo real
docker-compose logs -f

# Ver logs de un contenedor específico
docker logs SEPA_web
docker logs SEPA_DB

# Acceder a la terminal del contenedor web
docker exec -it SEPA_web bash

# Acceder a la consola de MySQL
docker exec -it SEPA_DB mysql -u sepa_user -p sepa_db
```

### Arquitectura Docker

```
┌──────────────────────────────────────────────────┐
│                  Máquina Virtual                 │
│                                                  │
│  ┌──────────────── sepa_network ───────────────┐ │
│  │                                             │ │
│  │  ┌─────────────┐     ┌──────────────────┐   │ │
│  │  │  SEPA_DB     │     │   SEPA_web       │   │ │
│  │  │  MySQL 8.0   │◄────│   Apache2+PHP8.4 │   │ │
│  │  │  Puerto 3306 │     │   Puerto 80      │   │ │
│  │  │  (interno)   │     │                  │   │ │
│  │  └─────────────┘     └──────────────────┘   │ │
│  │                              │               │ │
│  └──────────────────────────────┼───────────────┘ │
│                                 │                 │
│                          Puerto 8080              │
└─────────────────────────────────┼─────────────────┘
                                  │
                            Acceso externo
                        http://localhost:8080
```

---

## Estado del proyecto

El proyecto se encuentra en desarrollo activo. Se irán incorporando nuevas funcionalidades y mejoras conforme avance la simulación del proceso aduanero.

## Licencia

Este proyecto se distribuye con fines académicos y educativos.
