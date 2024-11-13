<?php
session_start();

// Verificar si el formulario fue enviado y se ha hecho clic en el botón "confirmar"
if (isset($_POST['confirmar'])) {
    // Guardar los datos en la sesión
    $_SESSION['nombre'] = $_POST['nombre'];
    $_SESSION['edad'] = $_POST['edad'];
    $_SESSION['nick'] = $_POST['nick'];
    $_SESSION['pwd'] = $_POST['pwd'];
}

// Verificar si los datos existen en la sesión antes de mostrarlos
if (!isset($_SESSION['nombre']) || !isset($_SESSION['edad']) || !isset($_SESSION['nick']) || !isset($_SESSION['pwd'])) {
    echo "Los datos de sesión no están completos.";
    exit();
}

// Variable para mostrar la etiqueta correspondiente de edad
$etiquetaEdad = "";
$imagenJoven = ""; // Inicializa vacía

if ($_SESSION['edad'] >= 15 && $_SESSION['edad'] <= 20) {
    $etiquetaEdad = " (joven)";
    // Inserta la URL de la imagen si es joven
    $imagenJoven = '<img src="../img/line-icon-for-youth-vector.jpg" alt="icono joven" width="20">';
} elseif ($_SESSION['edad'] > 60) {
    $etiquetaEdad = " (senior)";
}

// Verificar si el usuario ha confirmado la creación
if (isset($_POST['confirmado'])) {
    // Mostrar el mensaje de confirmación con los detalles del usuario
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LibroSphere - Confirmación de Usuario</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
                background-color: #f4f4f4;
                color: #333;
            }
            .logo {
                font-size: 24px;
                margin-top: 50px;
                font-weight: bold;
            }
            .logo span {
                color: #000;
                background-color: #ccc;
                padding: 2px 5px;
                border-radius: 50%;
            }
            h2 {
                color: #555;
            }
            .contenedor {
                margin: 20px auto;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                width: 50%;
                box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            }
            a {
                text-decoration: none;
                color: #333;
                font-weight: bold;
            }
            a:hover {
                text-decoration: underline;
            }
            .boton {
                margin-top: 20px;
            }
            .edad-icono {
                font-size: 20px;
            }
        </style>
    </head>
    <body>
        <div class="logo">
            LibroSphere <span>Tu biblioteca en línea</span>
        </div>
        <div class="contenedor">
            <h2>El usuario ' . $_SESSION['nick'] . ' ha sido creado satisfactoriamente</h2>
            <p>Nombre: ' . $_SESSION['nombre'] . '</p>
            <p>Edad: ' . $_SESSION['edad'] . ' ' . $etiquetaEdad . ' ' . $imagenJoven . '</p>
            <div class="boton">
                <a href="../index.php">Volver a la página de inicio</a>
            </div>
        </div>
    </body>
    </html>';
    exit();
}

// Verificar si el usuario ha cancelado
if (isset($_POST['cancelar'])) {
    // Volver a mostrar el formulario con los campos rellenos
    header("Location: confirmarUsuario.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisar Datos</title>
    <link rel="stylesheet" href="./styles/confirmar.css">
</head>

<body>
    <div class="container">
        <?php include '../include/cabecera.html'; ?>

        <h2>Revisar Datos del Usuario</h2>

        <form method="post" action="confirmarUsuario.php">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $_SESSION['nombre']; ?>" required>

            <label for="edad">Edad:</label>
            <input type="text" name="edad" value="<?php echo isset($_SESSION['edad']) ? $_SESSION['edad'] . ' ' . $etiquetaEdad : ''; ?>" required>
            
            <label for="nick">Nombre de usuario:</label>
            <input type="text" name="nick" value="<?php echo $_SESSION['nick']; ?>" required>

            <label for="pwd">Contraseña:</label>
            <input type="password" name="pwd" value="<?php echo $_SESSION['pwd']; ?>" required>

            <br><br><br>

            <!-- Botón para confirmar -->
            <button type="submit" name="confirmado">Confirmar y Guardar</button>

            <!-- Botón para cancelar y volver al formulario -->
            <button type="submit" name="cancelar">Cancelar</button>
        </form>
    </div>

    <footer>
        <!-- Puntos decorativos o iconos -->
        <div class="dots">
            <img src="ruta/a/icono1.png" alt="Icono 1">
            <img src="ruta/a/icono2.png" alt="Icono 2">
        </div>
    </footer>
</body>

</html>
