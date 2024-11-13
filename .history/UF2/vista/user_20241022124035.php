<?php
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
$libros = simplexml_load_file('../assets/libreira.xml');
?>

<h2>Bienvenido, <?php echo $_SESSION['usuario']; ?>. Aquí está el catálogo de libros:</h2>

<div>
    <?php
    foreach ($libros->libro as $libro) {
        $titulo = $libro->titulo;
        $autor = $libro->autor;
        $categoria = $libro->categoria;
        $portada = $libro->portada;
        $promocion = $libro->promocion == 'true';

        echo "<div>";
        echo "<h3>$titulo</h3>";
        echo "<p>Autor: $autor</p>";
        echo "<p>Categoría: $categoria</p>";
        echo "<img src='../assets/img/$portada' alt='$titulo' style='width:100px; height:150px;'>";
        echo "<button>Comprar</button>";

        // Mostrar si hay promoción
        if ($promocion) {
            echo "<p style='color:red;'>¡30% de descuento!</p>";
        }

        echo "</div>";
    }
    ?>
</div>

<a href="../controlador/logout.php">Cerrar Sesión</a>
