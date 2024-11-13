<?php
session_start();
// if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
//     header("Location: login.php");
//     exit();
// }

include 'controlador/conexion.php';

// Consulta para obtener todos los clientes
$consulta = "SELECT * FROM usuarios WHERE nick_usuario != 'admin'";
$resultado = $conexion->query($consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes</title>
</head>
<body>
    <h2>Gestión de Clientes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Nick</th>
            <th>Acciones</th>
        </tr>
        <?php while ($cliente = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                <td><?php echo htmlspecialchars($cliente['edad']); ?></td>
                <td><?php echo htmlspecialchars($cliente['nick_usuario']); ?></td>
                <td>
                    <a href="actualizarCliente.php?id=<?php echo $cliente['id']; ?>">Actualizar</a>
                    <a href="eliminarCliente.php?id=<?php echo $cliente['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este cliente?');">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <a href="panelControl.php">Volver al Panel de Control</a>
</body>
</html>
