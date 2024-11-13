<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "1234", "biblioteca");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si los datos de usuario están en la sesión
if (isset($_SESSION['usuario_datos'])) {
    $nombre = $_SESSION['usuario_datos']['nombre'];
    $edad = $_SESSION['usuario_datos']['edad'];
    $nick = $_SESSION['usuario_datos']['nick'];
    $contrasena = $_SESSION['usuario_datos']['contrasena'];
}

// Verificar si se ha enviado la confirmación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
    // Verificar si el nick_usuario ya existe
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nick_usuario = ?");
    $stmt->bind_param("s", $nick);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        echo "El nick de usuario ya está en uso. Por favor elige otro.";
    } else {
        // Inserción en la base de datos
        $stmt_insert = $conn->prepare("INSERT INTO usuarios (nombre, edad, nick_usuario, contrasena) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("siss", $nombre, $edad, $nick, $contrasena);

        if ($stmt_insert->execute()) {
            echo "Usuario creado con éxito";
            unset($_SESSION['usuario_datos']); // Limpiamos la sesión después de crear el usuario
        } else {
            echo "Error al crear el usuario: " . $stmt_insert->error;
        }

        $stmt_insert->close();
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Usuario - LibroSphere</title>
</head>
<body>
    <h2>Revisar Datos del Usuario</h2>
    <form action="confirmarUsuario.php" method="post">
        <p>Nombre: <?= htmlspecialchars($nombre) ?></p>
        <p>Edad: <?= htmlspecialchars($edad) ?></p>
        <p>Nombre de usuario: <?= htmlspecialchars($nick) ?></p>
        <input type="hidden" name="confirmar" value="1">
        <button type="submit">Confirmar y Guardar</button>
    </form>
</body>
</html>
