<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "1234", "biblioteca");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $edad = isset($_POST['edad']) && $_POST['edad'] !== '' ? (int)$_POST['edad'] : null;
    $nick = isset($_POST['nick']) ? $_POST['nick'] : null;
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : null;

    // Preparar una consulta para verificar si el nick_usuario ya existe
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nick_usuario = ?");
    $stmt->bind_param("s", $nick);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        echo "El nick de usuario ya está en uso. Por favor elige otro.";
    } else {
        // Hashear la contraseña antes de guardarla
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Preparar y ejecutar la consulta de inserción
        $stmt_insert = $conn->prepare("INSERT INTO usuarios (nombre, edad, nick_usuario, contrasena) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("siss", $nombre, $edad, $nick, $contrasena_hash);

        if ($stmt_insert->execute()) {
            echo "Usuario creado con éxito";
        } else {
            echo "Error al crear el usuario: " . $stmt_insert->error;
        }

        $stmt_insert->close();
    }

    $stmt->close();
}
?>
