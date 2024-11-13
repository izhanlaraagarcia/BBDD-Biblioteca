<?php

class biblitecaBD{
    private static $conexion = null;
    private static funcion conexionBD(){
        if(self:: $conexion === null){
            self::$conexion = new mysqli("server", "user", "pasw", "bd");
        }
        if(self::$conexion->connect_error){
            die("Error en la conexio: " . self::$conexion->connect_error)
        }
    }
}

?>