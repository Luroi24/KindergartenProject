<?php

// $mysqli = new mysqli("localhost","root","","dbtecweb");
// if($mysqli->conect_errno){
//     echo "Fallo al conectar a mySQL: (".$mysqli->connect_errno.") ".$mysqli->connect_error;
// }else{

// }
// $table = $_POST['table'];
include 'conexion.php';
$folio=$_POST["folio"];
$sql="SELECT folio FROM MORRO where folio='$folio'";
$result=mysqli_query($conexion, $sql);
// $myInt = (int)$result;
// $items = (string)$myInt;
$row=mysqli_fetch_assoc($result);
// echo $folio;
if(is_null($row)){
    echo FALSE;
}else{
    echo TRUE;
}
?>