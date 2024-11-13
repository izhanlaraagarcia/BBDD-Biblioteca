<?php

class Libro {
    private $titulo;
    private $autor;
    private $categoria;
    private $portada;
    private $promocion;

    public function __construct($titulo, $autor, $categoria, $portada, $promocion) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->categoria = $categoria;
        $this->portada = $portada;
        // Aseguramos que el valor 'si' sea convertido a true y 'no' a false
        $this->promocion = strtolower(trim($promocion)) == 'si'; 
    }

    public function mostrarInfo() {
        echo "<div>";
        echo "<h3>{$this->titulo}</h3>";
        echo "<p>Autor: {$this->autor}</p>";
        echo "<p>Categoría: {$this->categoria}</p>";
        echo "<img src='../assets/img/{$this->portada}' alt='Portada'>";

        // Verificamos si está en promoción
        if ($this->promocion) {
            // Mostrar texto de descuento o imagen de promoción
            echo "<p><strong>¡30% de descuento!</strong></p>";
        }

        echo "<button>Comprar</button>";
        echo "</div>";
    }
}

?>
