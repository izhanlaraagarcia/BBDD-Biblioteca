<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "1234", "biblioteca");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Datos del formulario
$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$nick_usuario = $_POST['nick'];

if (isset($_POST['pwd'])) {
    $contrasena = hash('sha256', $_POST['pwd']);
} else {
    die("Error: La contraseña no ha sido proporcionada.");
}

// Verificar si el nick_usuario ya existe
$check_nick = "SELECT * FROM usuarios WHERE nick_usuario = '$nick_usuario'";
$result = $conn->query($check_nick);

if ($result->num_rows > 0) {
    die("Error: El nombre de usuario ya está en uso.");
}

// Consulta para insertar el usuario
$sql = "INSERT INTO usuarios (nombre, edad, nick_usuario, contrasena) VALUES ('$nombre', '$edad', '$nick_usuario', '$contrasena')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario creado con éxito";
} else {
    echo "Error al crear el usuario: " . $conn->error;
}

$conn->close();
?>
