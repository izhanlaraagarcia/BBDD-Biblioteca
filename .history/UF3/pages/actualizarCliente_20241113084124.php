<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../controlador/conexion.php';

// Verificar si se ha pasado el ID del usuario para editar
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Obtener la información actual del usuario
    $sql = "SELECT * FROM usuarios WHERE id = $id";
    $resultado = $conn->query($sql);
    
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
    } else {
        echo "Usuario no encontrado";
        exit();
    }
} else {
    echo "ID de usuario no válido";
    exit();
}

// Procesar la actualización si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $edad = intval($_POST['edad']);
    $nick_usuario = $_POST['nick_usuario'];

    // Actualizar el usuario en la base de datos
    $sql = "UPDATE usuarios SET nombre='$nombre', edad=$edad, nick_usuario='$nick_usuario' WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Usuario actualizado con éxito";
        header("Location: gestionClientes.php");
        exit();
    } else {
        echo "Error al actualizar el usuario: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Cliente</title>
</head>
<body>
    <h2>Actualizar Cliente</h2>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required><br>

        <label for="edad">Edad:</label>
        <input type="number" name="edad" value="<?php echo htmlspecialchars($usuario['edad']); ?>" required><br>

        <label for="nick_usuario">Nick:</label>
        <input type="text" name="nick_usuario" value="<?php echo htmlspecialchars($usuario['nick_usuario']); ?>" required><br>

        <input type="submit" value="Actualizar Usuario">
    </form>
    <a href="gestionClientes.php">Volver a la Gestión de Clientes</a>
</body>
</html>
