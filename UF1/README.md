# UF1 - Sistema de Autenticación - PHP

## Descripción del Proyecto

Este proyecto consiste en un sistema básico de autenticación en PHP que permite a los usuarios iniciar sesión y gestionar sus datos de sesión. La autenticación se realiza con credenciales estáticas y se proporciona feedback al usuario en caso de errores, mediante alertas JavaScript.



## Instalación

1. **Servidor Web y PHP**: Asegúrate de tener un servidor web con soporte para PHP (XAMPP, WAMP, etc.). Coloca la carpeta `biblioteca` en el directorio raíz de tu servidor local.
2. **Acceso al Proyecto**: Para iniciar sesión, utiliza las credenciales predeterminadas:

   - **Usuario**: `admin`
   - **Contraseña**: `abcdef`

---

## Estructura de Archivos

```
biblioteca/
│
├── img/
│   └── line-icon-for-youth-vector.jpg
│
├── include/
│   ├── cabecera.html
│   └── formulario.php
│
├── sesiones/
│   ├── altaUsuario.php
│   ├── cerrarSesion.php
│   ├── confirmarUsuario.php
│   ├── validarSesion.php
│   └── styles/
│       ├── alta.css
│       ├── confirmar.css
│
├── styles/
│   ├── main.css
│
├── index.php
└── README.md (este archivo)
```

---

## Flujo del Sistema

### 1. **Formulario de Inicio de Sesión (`formulario.php`)**  
   El usuario introduce sus credenciales (usuario y contraseña). El formulario envía estos datos al archivo `validarSesion.php` para su validación.

### 2. **Validación de Sesión (`validarSesion.php`)**
   - Si las credenciales son correctas (usuario == 'admin' y pwd == 'abcdef'), se inicia una sesión, se almacena el nombre del usuario y la hora de inicio, y se redirige al usuario a la página principal (`index.php`).
   - Si las credenciales son incorrectas, se almacena un mensaje de error en la sesión y se redirige de nuevo al formulario de inicio de sesión. El formulario mostrará una alerta con el mensaje de error usando JavaScript.

### 3. **Manejo de Errores**
   En caso de error en la autenticación, se utiliza un mensaje de alerta en JavaScript que se activa en el archivo `formulario.php`. El mensaje de error se guarda en la sesión y se muestra solo una vez.

---

## Ejemplo de `validarSesion.php`

```php
<?php
session_start();

function alerta($mensaje) {
    echo "<script>alert('$mensaje');</script>";
}

if (isset($_POST['usuario']) && isset($_POST['pwd'])) {
    $usuario = $_POST['usuario'];
    $pwd = $_POST['pwd'];

    if ($usuario == "admin" && $pwd == "abcdef") {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['hora'] = date("d-m-Y H:i:s");
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos";
        header("Location: ../include/formulario.php");
        exit();
    }
}

include "../include/cabecera.html";
?>
```

---

## Ejemplo de `formulario.php`

```php
<?php
session_start();

if (isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . "');</script>";
    unset($_SESSION['error']); // Eliminamos el mensaje de error después de mostrarlo
}

include "./cabecera.html";
?>

<section class="completo">
    <article class="centrado">
        <h2>Formulario de Registro</h2>
        <form action="../sesiones/validarSesion.php" method="post">
            <div class="formulario-conjunto">
                <label for="usuario">Usuario:</label>
                <input type="text" id="nombre" name="usuario" required>
            </div>

            <div class="formulario-conjunto">
                <label for="pwd">Contraseña:</label>
                <input type="password" id="pwd" name="pwd" required>
            </div>

            <div class="formulario-conjunto">
                <button type="submit">Enviar</button>
            </div>
        </form>
    </article>
</section>
```

---

## Personalización

Si necesitas cambiar las credenciales por defecto para el inicio de sesión, simplemente edita las siguientes líneas en `validarSesion.php`:

```php
if ($usuario == "admin" && $pwd == "abcdef") {
    // Aquí puedes cambiar el usuario y contraseña por los valores que prefieras.
}
```


## Firma

> Izhan Lara Garcia