<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != 'user') {
    header("Location: ../index.php");
    exit();
}

$_SESSION['ultimo_acceso'] = time(); // Actualizar tiempo de último acceso

// Incluir el archivo que contiene la clase Libro
require_once '../modelo/Libro.php'; 

include 'header.php';

// Cargar los libros desde biblioteca.xml
$libros = simplexml_load_file('../assets/biblioteca.xml');
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

        $libroObj = new Libro($titulo, $autor, $categoria, $portada, $promocion);
        $libroObj->mostrarInfo();
    }
    ?>
</div>

<a href="../controlador/logout.php">Cerrar Sesión</a>
