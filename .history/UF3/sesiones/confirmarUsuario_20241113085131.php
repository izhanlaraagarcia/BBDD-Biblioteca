<?php
session_start();
include '../controlador/conexion.php';
include '../data/bibliotecaBD.php';

// Verificar si el formulario fue enviado y se ha hecho clic en el botón "confirmar" de la página de registro
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
    // Verificar si el nick ya existe en la base de datos usando una consulta preparada
    $nick = $_SESSION['nick'];
    
    // Añadir comprobación de conexión
    if (!$conn) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM usuarios WHERE nick_usuario = ?");
    $stmt->bind_param("s", $nick);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado) {
        $fila = $resultado->fetch_assoc();
        
        // Mostrar valor para depuración
        echo "Resultado de verificación de usuario: " . $fila['total'] . "<br>";

        if ($fila['total'] > 0) {
            echo "Error: El nombre de usuario ya existe.";
            exit();
        } else {
            // Insertar el nuevo usuario usando una consulta preparada
            $nombre = $_SESSION['nombre'];
            $edad = $_SESSION['edad'];
            $pwd = $_SESSION['pwd'];
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, edad, nick_usuario, contrasena) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("siss", $nombre, $edad, $nick, $pwd);

            if ($stmt->execute()) {
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
                
                // Limpiar los datos de la sesión después de crear el usuario
                session_unset();
                session_destroy();
            } else {
                echo "Error al insertar usuario: " . $stmt->error;
            }
        }
    } else {
        echo "Error al verificar la existencia del usuario: " . $conn->error;
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
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($_SESSION['nombre']); ?>" readonly>

            <label for="edad">Edad:</label>
            <input type="number" name="edad" value="<?php echo htmlspecialchars($_SESSION['edad']); ?>" readonly>

            <label for="nick">Nombre de usuario:</label>
            <input type="text" name="nick" value="<?php echo htmlspecialchars($_SESSION['nick']); ?>" readonly>

            <br><br>

            <!-- Botón para confirmar -->
            <button type="submit" name="confirmado">Confirmar y Guardar</button>

            <!-- Botón para cancelar -->
            <button type="submit" name="cancelar">Cancelar</button>
        </form>
    </div>
</body>
</html>
