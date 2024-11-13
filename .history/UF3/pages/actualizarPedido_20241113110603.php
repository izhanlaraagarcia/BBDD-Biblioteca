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

    // Obtener los datos actuales del pedido
    $consulta = "SELECT * FROM pedidos WHERE id = $id";
    $resultado = $conn->query($consulta);

    if ($resultado->num_rows > 0) {
        $pedido = $resultado->fetch_assoc();
    } else {
        echo "Pedido no encontrado";
        exit();
    }
} else {
    echo "ID de pedido no válido";
    exit();
}

// Procesar la actualización si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $isbn = $_POST['isbn'];
    $fecha = $_POST['fecha'];
    $usuario = $_POST['usuario'];

    // Actualizar el pedido en la base de datos
    $sql = "UPDATE pedidos SET titulo=?, isbn=?, fecha=?, usuario=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $titulo, $isbn, $fecha, $usuario, $id);

    if ($stmt->execute()) {
        echo "Pedido actualizado con éxito";
        header("Location: gestionPedidos.php");
        exit();
    } else {
        echo "Error al actualizar el pedido: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Pedido</title>
</head>
<body>
    <h2>Actualizar Pedido</h2>
    <form method="POST">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" value="<?php echo htmlspecialchars($pedido['titulo']); ?>" required><br>

        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" value="<?php echo htmlspecialchars($pedido['isbn']); ?>" required><br>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" value="<?php echo htmlspecialchars($pedido['fecha']); ?>" required><br>

        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" value="<?php echo htmlspecialchars($pedido['usuario']); ?>" required><br>

        <input type="submit" value="Actualizar Pedido">
    </form>
    <a href="gestionPedidos.php">Volver a la Gestión de Pedidos</a>
</body>
</html>
