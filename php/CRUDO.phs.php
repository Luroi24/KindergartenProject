<?php  

$mysqli = new mysqli("localhost", "root", "", "dbtecweb");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
/*echo $mysqli->host_info . "\n";*/

$sql = "SELECT FOLIO, NOM, APE_PAT, APE_MAT, FOTO FROM MORRO";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  echo "<center><table>";
  echo "<tr> <th> FOLIO </th> <th> NOMBRE </th> <th> APELLIDO PATERNO </th> <th> APELLIDO MATERNO </th><th width=20%> FOTO </th><th> ELIMINAR </th> <th> MODIFICAR </th> </tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>
    		<td><center> ". $row["FOLIO"]." </center></td>
    		<td><center> " . $row["NOM"]. " </center></td>
    		<td><center> " . $row["APE_PAT"]. " </center></td>
    		<td><center> " . $row["APE_MAT"]. " </center></td> 
    		<td><center><img src='img/" . $row["FOTO"]. "' width=75%/></center></td>
    		<td><center><form method='post' action='CRUDD.php'><input type='submit' name='fol' value='" . $row["FOLIO"]. "'></form></center></td> 
    		<td><center><form method='post' action='CRUDU.php'><input type='submit' name='fol' value='" . $row["FOLIO"]. "'></form></center></td>
    	  </tr>";
  }
} else {
  echo "0 results";
}

/*public function Registrar(Vehiculo $data){
 try
 {
 $sql = "INSERT INTO MORRO (FOLIO,CENDI_idCENDI,AP_PAT,AP_MAT,NOM,FECHAN,EDAD,CURP,FOTO,2PADRES,CITAS_idCITAS,ENTREVISTA_idENTREVISTA)
 VALUES (?, ?, ?)";
 $this->pdo->prepare($sql)
 ->execute(
 array(
 $data->__GET('marca'),
 $data->__GET('modelo'),
 $data->__GET('kilometros')
 )
 );
 } catch (Exception $e)
 {
 die($e->getMessage());
 }
}*/


$mysqli->close();

?>