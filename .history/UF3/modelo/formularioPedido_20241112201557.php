<?php
session_start();
include 'controlador/conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener los datos del libro del enlace
$titulo = $_GET['titulo'] ?? '';
$isbn = $_GET['isbn'] ?? '';
$fecha = date("Y-m-d");  // Fecha actual
$usuario = $_SESSION['usuario'];  // Usuario de la sesión activa

// Procesar el formulario si se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $isbn = $_POST['isbn'];
    $fecha = $_POST['fecha'];
    $usuario = $_POST['usuario'];

    // Insertar el pedido en la tabla 'pedidos'
    $consulta = "INSERT INTO pedidos (titulo, isbn, fecha, usuario) VALUES ('$titulo', '$isbn', '$fecha', '$usuario')";
    if ($conexion->query($consulta) === TRUE) {
        echo "<p>Pedido realizado</p>";
        echo "<a href='listadoLibros.php'>Volver al listado de libros</a>";
    } else {
        echo "<p>Error al realizar el pedido: " . $conexion->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Realizar Pedido</title>
</head>
<body>
    <h2>Formulario de Pedido</h2>
    <form method="post" action="formularioPedido.php">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>" readonly><br>
        
        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>" readonly><br>
        
        <label for="fecha">Fecha de Compra:</label>
        <input type="text" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>" readonly><br>
        
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>" readonly><br>
        
        <button type="submit">Confirmar Pedido</button>
    </form>
</body>
</html>
