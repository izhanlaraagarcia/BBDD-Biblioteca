<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "admin", "", "biblioteca");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Datos del formulario
$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$nick_usuario = $_POST['nick_usuario'];
$contrasena = hash('sha256', $_POST['contrasena']); // Encriptación con sha256

// Consulta para insertar el usuario
$sql = "INSERT INTO usuarios (nombre, edad, nick_usuario, contrasena) VALUES ('$nombre', '$edad', '$nick_usuario', '$contrasena')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario creado con éxito";
} else {
    echo "Error al crear el usuario: " . $conn->error;
}

$conn->close();
?>
