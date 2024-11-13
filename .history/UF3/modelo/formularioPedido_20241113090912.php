<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

include '../controlador/conexion.php'; // Incluye la conexión a la base de datos, si es necesario

// Recibir los datos enviados en la URL
$titulo = isset($_GET['titulo']) ? $_GET['titulo'] : '';
$isbn = isset($_GET['isbn']) ? $_GET['isbn'] : '';

// Obtener el usuario de la sesión
$usuario = $_SESSION['usuario'];

// Fecha actual
$fechaCompra = date("Y-m-d");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pedido</title>
</head>
<body>
    <h2>Formulario de Pedido</h2>

    <!-- Formulario para confirmar la compra -->
    <form action="procesarPedido.php" method="POST">
        <label for="titulo">Título del Libro:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>" readonly>
        <br>

        <label for="isbn">ISBN del Libro:</label>
        <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>" readonly>
        <br>

        <label for="fecha_compra">Fecha de Compra:</label>
        <input type="text" id="fecha_compra" name="fecha_compra" value="<?php echo $fechaCompra; ?>" readonly>
        <br>

        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>" readonly>
        <br>

        <input type="submit" value="Confirmar Pedido">
    </form>

    <a href="../index.php">Volver al listado de libros</a>
</body>
</html>
