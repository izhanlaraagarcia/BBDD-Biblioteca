<?php
//archivo conexion con la base de datos
$server = "localhost";
$user = "root";
$pass = "";
$db = "biblioteca";

$conn = new mysqli($server, $user, $pass, $db);
//verificamos la conexio

if($conn -> connect_error){
    die("Error en la conexion: " . $conn->connect_error);
}
?>