<?php
// Aqui cambian las cosas para que se pueda conectar a su base de datos
// y asi no tener que hacerlo en cada documento pendejos >:(

$server ='localhost';
$user='root';
$pass='';
$bd='dbtecweb';
$conexion = new mysqli($server,$user,$pass,$bd);
if(!$conexion){
    die(mysqli_error($conexion));
}

?>