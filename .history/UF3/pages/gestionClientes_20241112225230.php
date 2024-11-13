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

// Consulta para obtener todos los clientes
$consulta = "SELECT * FROM usuarios WHERE nick_usuario != 'admin'";
$resultado = $conn->query($consulta);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}
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
    <a href="../vista/admin.php">Volver al Panel de Control</a>
</body>
</html>

<?php
// Cerrar la conexión al final de la página
$conn->close();
?>
