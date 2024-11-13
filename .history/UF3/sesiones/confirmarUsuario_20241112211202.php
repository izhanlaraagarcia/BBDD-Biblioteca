<?php
session_start();
include '../controlador/conexion.php';
include "../data/bibliotecaBD.php";
// Verificar si el formulario fue enviado y se ha hecho clic en el botón "confirmar"
if (isset($_POST['confirmar'])) {
    // Guardar los datos en la sesión
    $_SESSION['nombre'] = $_POST['nombre'];
    $_SESSION['edad'] = $_POST['edad'];
    $_SESSION['nick'] = $_POST['nick'];
    $_SESSION['pwd'] = password_hash($_POST['pwd'], PASSWORD_DEFAULT); // Encriptar la contraseña antes de guardarla en la sesión
}

// Verificar si los datos existen en la sesión antes de mostrarlos
if (!isset($_SESSION['nombre']) || !isset($_SESSION['edad']) || !isset($_SESSION['nick'])) {
    echo "Los datos de sesión no están completos.";
    exit();
}

// Variable para mostrar la etiqueta correspondiente de edad
$etiquetaEdad = "";
$imagenJoven = "";

if ($_SESSION['edad'] >= 15 && $_SESSION['edad'] <= 20) {
    $etiquetaEdad = " (joven)";
    $imagenJoven = '<img src="../img/line-icon-for-youth-vector.jpg" alt="icono joven" width="20">';
} elseif ($_SESSION['edad'] > 60) {
    $etiquetaEdad = " (senior)";
}

if (isset($_POST['confirmado'])) {
    try {
        // Preparar la consulta SQL
        $nombre = $_SESSION['nombre'];
        $edad = $_SESSION['edad'];
        $nick = $_SESSION['nick'];
        $password = $_SESSION['pwd'];

        // Crear la consulta SQL
        $consulta = "INSERT INTO usuarios (nombre, edad, nick_usuario, contrasena) VALUES ('$nombre', $edad, '$nick', '$pwd')";

        // Ejecutar la consulta usando el método de la clase BibliotecaBD
        if (BibliotecaBD::consultarInsertar($consulta)) {
            echo '<p>El usuario se ha registrado en la base de datos exitosamente.</p>';
        } else {
            echo "Error al insertar usuario.";
        }


        // Confirmación de creación en la base de datos
        echo '<p>El usuario se ha registrado en la base de datos exitosamente.</p>';
    } catch (PDOException $e) {
        echo "Error al insertar usuario: " . $e->getMessage();
    }


    $nick = $_SESSION['nick'];

    // Verificar si el nick_usuario ya existe
    $consultaExistencia = "SELECT COUNT(*) AS total FROM usuarios WHERE nick_usuario = '$nick'";
    $resultado = $conexion->query($consultaExistencia);
    $fila = $resultado->fetch_assoc();

    if ($fila['total'] > 0) {
        echo "Error: El nombre de usuario ya existe.";
    } else {
        // Insertar el usuario si el nombre de usuario no existe
        $consulta = "INSERT INTO usuarios (nombre, edad, nick_usuario, contrasena) VALUES ('$nombre', $edad, '$nick', '$pwd')";
        if ($conexion->query($consulta) === TRUE) {
            echo "Usuario registrado correctamente.";
        } else {
            echo "Error al insertar usuario: " . $conexion->error;
        }
    }
    // Código HTML para mostrar la confirmación final
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
            <h2>El usuario ' . htmlspecialchars($_SESSION['nick']) . ' ha sido creado satisfactoriamente</h2>
            <p>Nombre: ' . htmlspecialchars($_SESSION['nombre']) . '</p>
            <p>Edad: ' . htmlspecialchars($_SESSION['edad']) . ' ' . $etiquetaEdad . ' ' . $imagenJoven . '</p>
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
    // Redirigir al formulario de registro en caso de cancelación
    header("Location: ./altaUsuario.php");
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
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($_SESSION['nombre']); ?>" required>

            <label for="edad">Edad:</label>
            <input type="number" name="edad" value="<?php echo htmlspecialchars($_SESSION['edad']); ?>" required>

            <label for="nick">Nombre de usuario:</label>
            <input type="text" name="nick" value="<?php echo htmlspecialchars($_SESSION['nick']); ?>" required>

            <label for="pwd">Contraseña:</label>
            <input type="password" name="pwd" placeholder="********">

            <br><br>

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