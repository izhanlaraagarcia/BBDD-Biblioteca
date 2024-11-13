<h2>Bienvenido, <?php echo $_SESSION['usuario']; ?>. Aquí está el catálogo de libros:</h2>

<div class="catalogo">
    <?php
    foreach ($libros->libro as $libro) {
        $titulo = $libro->titulo;
        $autor = $libro->autor;
        $categoria = $libro->categoria;
        $portada = $libro->portada;
        $promocion = (string)$libro->promocion == 'si';

        echo "<div>";
        echo "<h3>$titulo</h3>";
        echo "<p>Autor: $autor</p>";
        echo "<p>Categoría: $categoria</p>";
        echo "<img src='../assets/img/$portada' alt='$titulo'>";
        echo "<button>Comprar</button>";

        // Mostrar si hay promoción
        if ($promocion) {
            echo "<p class='promocion'>¡30% de descuento!</p>";
        }

        echo "</div>";
    }
    ?>
</div>
<a href="../controlador/logout.php">Cerrar Sesión</a>
