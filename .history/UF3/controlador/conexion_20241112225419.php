<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "1234", "biblioteca");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Datos del formulario
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$edad = isset($_POST['edad']) && $_POST['edad'] !== '' ? (int)$_POST['edad'] : null;  // Validar si edad está vacío y convertirlo a entero
$nick = isset($_POST['nick']) ? $_POST['nick'] : null;
$contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : null;

// Verificar si el nick_usuario ya existe
$check_nick = "SELECT * FROM usuarios WHERE nick_usuario = '$nick'";
$result = $conn->query($check_nick);

if ($result && $result->num_rows > 0) {
    echo "El nick de usuario ya está en uso. Por favor elige otro.";
} else {
    // Preparamos la consulta de inserción para evitar errores
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, edad, nick_usuario, contrasena) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $nombre, $edad, $nick, $contrasena);

    // Ejecutamos la consulta de inserción
    if ($stmt->execute()) {
        echo "Usuario creado con éxito";
    } else {
        echo "Error al crear el usuario: " . $stmt->error;
    }

    // Cerramos la consulta preparada
    $stmt->close();
}

// $conn->close();
?>
