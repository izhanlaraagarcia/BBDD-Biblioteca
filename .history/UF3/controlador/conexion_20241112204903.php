<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "1234", "biblioteca");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Datos del formulario
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$edad = isset($_POST['edad']) ? $_POST['edad'] : null;
$nick = isset($_POST['nick']) ? $_POST['nick'] : null;
$contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : null;

// Verificar que todos los datos estén presentes
if (!$nombre || !$edad || !$nick || !$contrasena) {
    die("Error: La información proporcionada está incompleta.");
}

if (isset($_POST['pwd'])) {
    $contrasena = hash('sha256', $_POST['pwd']);
} else {
    die("Error: La contraseña no ha sido proporcionada.");
}

// Verificar si el nick_usuario ya existe
$check_nick = "SELECT * FROM usuarios WHERE nick_usuario = '$nick'";
$result = $conn->query($check_nick);

// Consulta para insertar el usuario
$sql = "INSERT INTO usuarios (nombre, edad, nick_usuario, contrasena) VALUES ('$nombre', '$edad', '$nick_usuario', '$contrasena')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario creado con éxito";
} else {
    echo "Error al crear el usuario: " . $conn->error;
}

$conn->close();
?>
