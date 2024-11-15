<?php

class BibliotecaBD
{
    private static $conexion = null;

    private static function conexionBD()
    {
        if (self::$conexion === null) {
            self::$conexion = new mysqli("añadir host de mi bbdd", "user", "pasw", "bd");

            if (self::$conexion->connect_error) {
                die("Error en la conexión: " . self::$conexion->connect_error);
            }

            self::$conexion->set_charset("utf8");
        }
        return self::$conexion;
    }

    public static function consultarInsertar($consulta)
    {
        $conexion = self::conexionBD();
        if ($conexion->query($consulta)) {
            return true;
        } else {
            return false;
        }
    }

    public static function cerrarConexion()
    {
        if (self::$conexion !== null) {
            self::$conexion->close();
            self::$conexion == null;
        }
    }
}
