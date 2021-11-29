<?php

$host="localhost";
$bd="proyecto";
$usuario="Ani";
$contrasena="1234";

try {
    $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasena);
} catch ( Exception $ex) {
    echo $ex ->getMessage();
}

?>