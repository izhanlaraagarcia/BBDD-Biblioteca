<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include_once '../controlador/conexion.php';

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificar si el ID del pedido está presente en la URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Eliminar el pedido de la base de datos
    $sql = "DELETE FROM pedidos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Pedido eliminado con éxito";
    } else {
        echo "Error al eliminar el pedido: " . $stmt->error;
    }

    $stmt->close();
    header("Location: gestionPedidos.php");
    exit();
} else {
    echo "ID de pedido no válido";
    exit();
}
?>
