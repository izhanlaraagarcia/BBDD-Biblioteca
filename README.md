# Sistema de Gestión de una Biblioteca Online - LibroSphere

## Descripción del Proyecto
LibroSphere es una aplicación web desarrollada en PHP que permite gestionar una biblioteca online. Los usuarios pueden registrarse, buscar libros y gestionar préstamos, mientras que los administradores tienen acceso a funcionalidades avanzadas para la administración de usuarios y pedidos. Este proyecto ha sido desarrollado en el contexto de la Unidad Formativa 2 del módulo "Desarrollo Web en Entorno Servidor" del ciclo de **Desarrollo de Aplicaciones Web**.

## Objetivos de la Aplicación

1. **Desarrollar una aplicación web con acceso a base de datos (CRUD)** que permita realizar operaciones de creación, lectura, actualización y eliminación.
2. **Aplicar conocimientos sobre seguridad** para proteger los datos de acceso y encriptar las contraseñas.
3. **Implementar diferentes roles de usuario**, diferenciando entre administradores y usuarios comunes, con acceso a distintas funcionalidades.

## Características y Funcionalidades

### Funciones de Usuario

- **Registro de Usuarios**: Los usuarios pueden registrarse en la biblioteca proporcionando un nick único, nombre, edad y contraseña. La contraseña se almacena de forma segura usando el algoritmo SHA-256.
- **Login y Control de Sesiones**: Los usuarios inician sesión con sus credenciales. La sesión expira después de 30 minutos de inactividad.
- **Visualización de Libros**: Los usuarios pueden ver un listado de libros y hacer pedidos.
- **Pedidos**: Los usuarios pueden realizar pedidos de libros. El formulario de pedido se completa automáticamente con el título, ISBN, fecha y usuario activo.

### Funciones de Administrador

- **Gestión de Usuarios**: Los administradores pueden ver, editar y eliminar usuarios.
- **Gestión de Pedidos**: Los administradores pueden ver, actualizar y eliminar pedidos.
- **ERP de LibroSphere**: Los administradores acceden a un panel de control con enlaces para gestionar clientes, pedidos y (en el futuro) libros.

## Estructura del Proyecto

- **Directorio Principal**: El proyecto se almacena en el directorio `biblioteca`.
- **Archivo Principal**: `index.php` sirve como punto de entrada principal de la aplicación.
- **Cabecera**: Un archivo de cabecera común (incluido en cada página) contiene el nombre y colores de la biblioteca.

### Base de Datos

1. **Tabla de Pedidos**:
   ```sql
   CREATE TABLE pedidos (
       id INT AUTO_INCREMENT PRIMARY KEY,
       titulo VARCHAR(255) NOT NULL,
       isbn VARCHAR(13) NOT NULL,
       fecha DATE NOT NULL,
       usuario VARCHAR(10) NOT NULL
   );
   ```
2. **Tabla de Usuarios**:
   ```sql
   CREATE TABLE usuarios (
       id INT AUTO_INCREMENT PRIMARY KEY,
       nombre VARCHAR(100),
       edad INT,
       nick_usuario VARCHAR(10) UNIQUE,
       contrasena VARCHAR(255)
   );
   ```

### Configuración de Base de Datos

Se conecta a la base de datos `biblioteca` en `localhost` usando el usuario `root` sin contraseña. Los datos de acceso están protegidos en un archivo de configuración `config.ini`.

## Tecnologías Utilizadas

- **PHP**: Lenguaje de desarrollo principal de la aplicación.
- **MySQL**: Base de datos para almacenar usuarios y pedidos.
- **SHA-256**: Algoritmo de encriptación de contraseñas.
- **HTML/CSS**: Interfaz de usuario básica.

## Instalación y Uso

1. **Servidor Web**: Se recomienda usar XAMPP u otro servidor con soporte PHP.
2. **Base de Datos**: Crear una base de datos llamada `biblioteca` e importar las tablas especificadas.
3. **Configuración de Acceso**: Crear un archivo `config.ini` para la configuración de la conexión a la base de datos.
4. **Ejecutar la Aplicación**: Iniciar el servidor web y abrir `index.php` en el navegador.

## Requisitos de Seguridad

1. **Contraseñas encriptadas**: Se utiliza SHA-256 para almacenar contraseñas de forma segura.
2. **Protección contra SQL Injection**: La aplicación usa consultas preparadas para evitar inyecciones SQL.

## Capturas de Pantalla

Incluye capturas de la aplicación abierta en un navegador para mostrar la interfaz de usuario y la funcionalidad.

## Comentarios y Documentación

Cada función y clase está documentada para explicar su propósito y funcionamiento. 

## Estructura del Código

- **BibliotecaBD**: Clase para la gestión de la conexión con la base de datos, con métodos para consultar e insertar datos, y cerrar la conexión.

## Autoría y Licencia

Este proyecto ha sido desarrollado para el Módulo Profesional 07 de Desarrollo Web Entorno Servidor del ciclo **Desarrollo de Aplicaciones Web**.

### Firma

> Izhan Lara garcia
---