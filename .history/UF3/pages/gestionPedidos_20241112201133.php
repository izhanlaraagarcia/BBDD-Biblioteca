<?php
session_start();
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: login.php");
    exit();
}

include 'controlador/conexion.php';

// Consulta para obtener todos los pedidos
$consulta = "SELECT * FROM pedidos";
$resultado = $conexion->query($consulta);
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
