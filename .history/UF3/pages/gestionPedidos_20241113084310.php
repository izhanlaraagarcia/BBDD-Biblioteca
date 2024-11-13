<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: ../index.php"); // Redirige al inicio si no es admin
    exit();
}

// Incluir el archivo de conexión solo una vez
include_once '../controlador/conexion.php';

// Verificar si la conexión está activa
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta para obtener todos los pedidos
$consulta = "SELECT * FROM pedidos";
$resultado = $conn->query($consulta);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Pedidos</title>
</head>
<body>
    <h2>Gestión de Pedidos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>ISBN</th>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Acciones</th>
        </tr>
        <?php while ($pedido = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($pedido['id']); ?></td>
                <td><?php echo htmlspecialchars($pedido['titulo']); ?></td>
                <td><?php echo htmlspecialchars($pedido['isbn']); ?></td>
                <td><?php echo htmlspecialchars($pedido['fecha']); ?></td>
                <td><?php echo htmlspecialchars($pedido['usuario']); ?></td>
                <td>
                    <a href="actualizarPedido.php?id=<?php echo $pedido['id']; ?>">Actualizar</a>
                    <a href="eliminarPedido.php?id=<?php echo $pedido['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este pedido?');">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <a href="panelControl.php">Volver al Panel de Control</a>
</body>
</html>

<?php
// Cerrar la conexión al final de la página
$conn->close();
?>
