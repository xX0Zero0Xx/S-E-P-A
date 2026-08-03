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

## Requisitos previos

Antes de instalar el proyecto, es recomendable preparar el entorno de desarrollo con el repositorio de configuración DevSetup, el cual incluye la documentación y scripts necesarios para instalar las herramientas requeridas.

- Repositorio recomendado:

Asegúrate de tener instalados: [github.com/xX0Zero0Xx/Dev-Setup.git](https://github.com/xX0Zero0Xx/Dev-Setup.git)

- PHP
- Composer
- Node.js y npm
- MySQL
- Git

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/xX0Zero0Xx/S-E-P-A.git
cd S-E-P-A
```

### 2. Crear la base de datos

```sql
CREATE DATABASE "Nombre de la DB";
CREATE USER 'nombre del usuario'@'host del usuario' IDENTIFIED BY 'contraceña para el usuario';
GRANT ALL PRIVILEGES ON simulador_cove.* TO 'nombre del usuario'@'host del usuario';
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
DB_DATABASE="Nombre de la DB"
DB_USERNAME="Nombre del usuario de la DB"
DB_PASSWORD="Contraseña del usuario"
```

### 4. Instalar dependencias

```bash
composer install
npm install
```

### 5. Ejecutar migraciones y seeders

```bash
php artisan migrate
php artisan db:seed
```

### 6. Generar clave de la aplicación

```bash
php artisan key:generate
php artisan config:clear
```

### 7. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

La aplicación estará disponible en:

```text
http://127.0.0.1:8000
```

## Estado del proyecto

El proyecto se encuentra en desarrollo activo. Se irán incorporando nuevas funcionalidades y mejoras conforme avance la simulación del proceso aduanero.

## Licencia

Este proyecto se distribuye con fines académicos y educativos.

NO, NO, NO COMIDA CHINA 50 PESO
