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
    
        if ($this->promocion == true) {
            echo "<p><strong>¡30% de descuento!</strong></p>";
        }
    
        // Enlace al formulario de pedido, pasando el título y el ISBN del libro como parámetros
        echo "<a href='formularioPedido.php?titulo=" . urlencode($this->titulo) . "&isbn=123456789'>Comprar</a>";
        echo "</div>";
    }
    
}
?>
