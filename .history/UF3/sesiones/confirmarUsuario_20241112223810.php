<?php
session_start();
include '../controlador/conexion.php'; // Asegúrate de que $conn esté correctamente inicializado aquí
include '../data/bibliotecaBD.php';  // No necesitas volver a crear la conexión si ya está incluida en "conexion.php"

// Verificar si el formulario fue enviado y se ha hecho clic en el botón "confirmar"
if (isset($_POST['confirmar'])) {
    $_SESSION['nombre'] = $_POST['nombre'];
    $_SESSION['edad'] = $_POST['edad'];
    $_SESSION['nick'] = $_POST['nick'];
    $_SESSION['pwd'] = password_hash($_POST['pwd'], PASSWORD_DEFAULT); // Encriptar la contraseña
}

// Verificar si los datos existen en la sesión antes de mostrarlos
if (!isset($_SESSION['nombre']) || !isset($_SESSION['edad']) || !isset($_SESSION['nick'])) {
    echo "Los datos de sesión no están completos.";
    exit();
}

$etiquetaEdad = "";
$imagenJoven = "";

// Etiqueta de edad
if ($_SESSION['edad'] >= 15 && $_SESSION['edad'] <= 20) {
    $etiquetaEdad = " (joven)";
    $imagenJoven = '<img src="../img/line-icon-for-youth-vector.jpg" alt="icono joven" width="20">';
} elseif ($_SESSION['edad'] > 60) {
    $etiquetaEdad = " (senior)";
}

if (isset($_POST['confirmado'])) {
    // Verificar si el nick ya existe en la base de datos
    $nick = $_SESSION['nick'];
    $consultaExistencia = "SELECT COUNT(*) AS total FROM usuarios WHERE nick_usuario = '$nick'";

    if ($conn instanceof mysqli) {
        $resultado = $conn->query($consultaExistencia);
        if ($resultado) {
            $fila = $resultado->fetch_assoc();
            if ($fila['total'] > 0) {
                echo "Error: El nombre de usuario ya existe.";
                exit();
            } else {
                // Insertar el nuevo usuario
                $nombre = $_SESSION['nombre'];
                $edad = $_SESSION['edad'];
                $pwd = $_SESSION['pwd'];
                $consulta = "INSERT INTO usuarios (nombre, edad, nick_usuario, contrasena) VALUES ('$nombre', $edad, '$nick', '$pwd')";

                if ($conn->query($consulta) === TRUE) {
                    echo "Usuario registrado correctamente.";
                    // Mostrar la confirmación final
                    echo '
                    <div class="contenedor">
                        <h2>El usuario ' . htmlspecialchars($_SESSION['nick']) . ' ha sido creado satisfactoriamente</h2>
                        <p>Nombre: ' . htmlspecialchars($_SESSION['nombre']) . '</p>
                        <p>Edad: ' . htmlspecialchars($_SESSION['edad']) . ' ' . $etiquetaEdad . ' ' . $imagenJoven . '</p>
                        <div class="boton">
                            <a href="../index.php">Volver a la página de inicio</a>
                        </div>
                    </div>';
                } else {
                    echo "Error al insertar usuario: " . $conn->error;
                }
            }
        } else {
            echo "Error al verificar la existencia del usuario: " . $conn->error;
        }
    } else {
        echo "Error: Conexión no válida";
    }
    exit();
}

// Verificar si el usuario ha cancelado
if (isset($_POST['cancelar'])) {
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

            <!-- Botón para cancelar -->
            <button type="submit" name="cancelar">Cancelar</button>
        </form>
    </div>
</body>
</html>
