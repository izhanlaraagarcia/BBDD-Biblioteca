session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != 'user') {
    header("Location: ../index.php");
    exit();
}

$_SESSION['ultimo_acceso'] = time(); // Actualizar tiempo de último acceso

include 'header.php'; // Incluir la cabecera de la empresa

// Mostrar información del usuario y la hora de acceso
echo "<p>Usuario: " . $_SESSION['usuario'] . "</p>";
echo "<p>Hora de acceso: " . date("H:i:s", $_SESSION['ultimo_acceso']) . "</p>";

// Cargar los libros desde biblioteca.xml
$libros = simplexml_load_file('../assets/libreria.xml');
?>
<head>
    <link rel="stylesheet" href="../main.css">
</head>
<h2>Bienvenido, <?php echo $_SESSION['usuario']; ?>. Aquí está el catálogo de libros:</h2>

<div>
    <?php
    foreach ($libros->libro as $libro) {
        $titulo = $libro->titulo;
        $autor = $libro->autor;
        $categoria = $libro->categoria;
        $portada = $libro->portada;
        $isbn = $libro->isbn; // Asegúrate de que el archivo XML tenga el campo ISBN
        $promocion = (string)$libro->promocion == 'si';

        echo "<div>";
        echo "<h3>$titulo</h3>";
        echo "<p>Autor: $autor</p>";
        echo "<p>Categoría: $categoria</p>";
        echo "<img src='../assets/img/$portada' alt='$titulo' style='width:100px; height:150px;'>";

        // Enlace al formulario de pedido
        echo "<a href='../vista/formularioPedido.php?titulo=" . urlencode($titulo) . "&isbn=" . urlencode($isbn) . "'>Comprar</a>";

        // Mostrar si hay promoción
        if ($promocion) {
            echo "<p style='color:red;'>¡30% de descuento!</p>";
        }

        echo "</div>";
    }
    ?>
</div>

<a href="../controlador/logout.php">Cerrar Sesión</a>
