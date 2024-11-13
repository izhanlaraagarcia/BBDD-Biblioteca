<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../controlador/conexion.php'; 

// Verificar que se haya pasado el ID del usuario
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Eliminar el usuario de la base de datos
    $sql = "DELETE FROM usuarios WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Usuario eliminado con éxito";
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }
} else {
    echo "ID de usuario no válido";
}

// Redireccionar de vuelta a la gestión de clientes después de la operación
header("Location: gestionClientes.php");
exit();
?>
