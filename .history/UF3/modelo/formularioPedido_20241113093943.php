<?php
session_start();

// Verificar que el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Inicializar variables
$titulo = $isbn = "";

// Verificar si tenemos un ISBN en la URL
$isbnLibro = $_GET['isbn'] ?? null; // Asegúrate de que el enlace incluya `?isbn=9788408184243`
if ($isbnLibro) {
    // Cargar el archivo XML
    $xml = simplexml_load_file("../assets/libreria.xml") or die("No se pudo cargar el archivo XML.");

    // Buscar el libro en el XML
    foreach ($xml->libro as $libro) {
        if ((string) $libro->isbn === $isbnLibro) {
            $titulo = (string) $libro->titulo;
            $isbn = (string) $libro->isbn;
            break;
        }
    }
}

// Definir la fecha actual para la compra y el usuario de sesión
$fechaCompra = date("Y-m-d");
$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Pedido</title>
</head>
<body>
    <h2>Formulario de Pedido</h2>

    <?php if (empty($titulo) || empty($isbn)): ?>
        <p><strong>Error:</strong> No se pudo cargar la información del libro. Por favor, intente nuevamente.</p>
        <a href="../vista/libros.php">Volver al listado de libros</a>
    <?php else: ?>
        <form action="procesarPedido.php" method="POST">
            <label for="titulo">Título del libro:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>" readonly><br>

            <label for="isbn">ISBN del libro:</label>
            <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>" readonly><br>

            <label for="fecha">Fecha de compra:</label>
            <input type="text" id="fecha" name="fecha" value="<?php echo $fechaCompra; ?>" readonly><br>

            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>" readonly><br>

            <input type="submit" value="Confirmar Pedido">
        </form>
    <?php endif; ?>
</body>
</html>
