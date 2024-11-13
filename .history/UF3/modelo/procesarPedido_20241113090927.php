<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

include '../controlador/conexion.php'; // Incluye la conexión a la base de datos

// Verificar si los datos del formulario fueron enviados
if (isset($_POST['titulo'], $_POST['isbn'], $_POST['fecha_compra'], $_POST['usuario'])) {
    $titulo = $_POST['titulo'];
    $isbn = $_POST['isbn'];
    $fechaCompra = $_POST['fecha_compra'];
    $usuario = $_POST['usuario'];

    // Insertar el pedido en la tabla 'pedidos'
    $stmt = $conn->prepare("INSERT INTO pedidos (titulo, isbn, fecha_compra, usuario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $isbn, $fechaCompra, $usuario);

    if ($stmt->execute()) {
        // Pedido realizado con éxito
        echo "<p>Pedido realizado</p>";
    } else {
        // Error al realizar el pedido
        echo "<p>Error al realizar el pedido. Por favor, inténtelo de nuevo.</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Datos incompletos. Por favor, regrese e intente nuevamente.</p>";
}
?>

<a href="../index.php">Volver al listado de libros</a>
