<?php
	$mysqli = new mysqli("localhost", "root", "", "dbtecweb");
	if ($mysqli->connect_errno) {
    	/*echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;*/
	}else{
		/*echo "coneccion exitosa";*/
	}
	$FOLIO = $_POST['fol']; 
	$sql = "DELETE FROM MORRO WHERE FOLIO = " . $FOLIO;
	$result=$mysqli->query($sql); /*esta es la sentencia que borra al morro */
	
	if($result){ /*no error*/
	//		$sql = "SELECT FOLIO, NOM_M, APE_PAT, APE_MAT, FOTO_M FROM MORRO";
	//		$result = $mysqli->query($sql);
	//		if($result->num_rows > 0){ /*no error*/
			$res=1;
	//		while($row = $result->fetch_assoc()) {
	/*    	$res=$res."<tr>
	    		<td><center> ". $row["FOLIO"]." </center></td>
	    		<td><center> " . $row["NOM_M"]. " </center></td>
	    		<td><center> " . $row["APE_PAT"]. " </center></td>
	    		<td><center> " . $row["APE_MAT"]. " </center></td> 
	    		<td><center><img src='img/" . $row["FOTO_M"]. "' width=75%/></center></td>
	    		<td><center><form id='eliminar' method='post'><input id='fol' type='submit' name='fol' value='" . $row["FOLIO"]. "'></form></center></td> 
	    		<td><center><form id='modificar' method='post'><input id='fol' type='submit' name='fol' value='" . $row["FOLIO"]. "'></form></center></td>
	    	  </tr>";
	  		}
	  		$res=$res."</table></center></div>";*/
		}else{ /*error*/
			$res=0;
	}
	echo $res;	
?>