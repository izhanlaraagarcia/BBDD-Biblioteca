<?php
session_start();

// Verificar que el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "1234", "biblioteca");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar que el formulario se haya enviado mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $isbn = $_POST['isbn'];
    $fecha = $_POST['fecha'];
    $usuario = $_POST['usuario'];

    // Insertar el pedido en la base de datos
    $stmt = $conn->prepare("INSERT INTO pedidos (titulo, isbn, fecha, usuario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $isbn, $fecha, $usuario);

    if ($stmt->execute()) {
        echo "Pedido realizado con éxito. <a href='../vista/libros.php'>Volver al listado de libros</a>";
    } else {
        echo "Error al realizar el pedido: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Método de solicitud no válido.";
}

$conn->close();
?>
