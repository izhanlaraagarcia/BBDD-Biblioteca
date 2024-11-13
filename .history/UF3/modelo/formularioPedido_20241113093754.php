<?php
session_start();

// Asegurarse de que el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "1234", "biblioteca");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Inicializar variables
$titulo = $isbn = "";

// Verificar si tenemos un ID de libro en la URL
$idLibro = $_GET['idLibro'] ?? null;
if ($idLibro) {
    // Mostrar el ID del libro para depuración
    echo "ID del libro recibido: " . htmlspecialchars($idLibro) . "<br>";

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("SELECT titulo, isbn FROM libros WHERE id = ?");
    $stmt->bind_param("s", $idLibro);
    $stmt->execute();
    $stmt->bind_result($titulo, $isbn);
    if ($stmt->fetch()) {
        // Datos del libro cargados correctamente
        echo "Libro encontrado: " . htmlspecialchars($titulo) . " - " . htmlspecialchars($isbn) . "<br>";
    } else {
        // Si no se encontró el libro
        echo "Libro no encontrado en la base de datos.<br>";
    }
    $stmt->close();
} else {
    echo "No se recibió el ID del libro en la URL.<br>";
}

// Cerrar conexión
$conn->close();

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
