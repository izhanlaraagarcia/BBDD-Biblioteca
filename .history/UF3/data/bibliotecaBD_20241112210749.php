<?php
class BibliotecaBD {
    public static function consultarInsertar($consulta) {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=biblioteca', 'root', '1234');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare($consulta);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error en la conexión: ' . $e->getMessage();
            return false;
        }
    }
}
?>
