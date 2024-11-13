<?php
session_start();

// Asegurarse de que el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Variables para el libro, obtén su ID o ISBN por URL (o desde otro mecanismo)
$idLibro = $_GET['idLibro'] ?? null; // El ID o ISBN del libro debe estar en la URL

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "1234", "biblioteca");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los detalles del libro de la base de datos
if ($idLibro) {
    $stmt = $conn->prepare("SELECT titulo, isbn FROM libros WHERE id = ?");
    $stmt->bind_param("s", $idLibro);
    $stmt->execute();
    $stmt->bind_result($titulo, $isbn);
    $stmt->fetch();
    $stmt->close();
}

// Definir la fecha actual para la compra y el usuario de sesión
$fechaCompra = date("Y-m-d");
$usuario = $_SESSION['usuario'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Pedido</title>
</head>
<body>
    <h2>Formulario de Pedido</h2>
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
</body>
</html>
