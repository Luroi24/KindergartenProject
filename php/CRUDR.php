<?php
	$mysqli = new mysqli("localhost", "root", "", "dbtecweb");
	if ($mysqli->connect_errno) {
    	echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}else{
		/*echo "coneccion exitosa";*/
	}
	$table = $_POST['table'];
	if($table=="MORRO"){
		$sql = "SELECT * FROM MORRO 
			INNER JOIN CENDI on CENDI_idCENDI=idCENDI 
			INNER JOIN CITAS on CITAS_idCITAS=idCITAS 
			INNER JOIN ENTREVISTA on ENTREVISTA_idENTREVISTA=idENTREVISTA
			INNER JOIN GRUPO on GRUPO_idGRUPO=idGRUPO";
    }elseif ($table=="DERECHOHABIENTE") {
		$sql="SELECT * FROM DERECHOHABIENTE 
			INNER JOIN OCUPACION on OCUPACION_ID=ID
            INNER JOIN ADSCRIPCION on idADS=ADSCRIPCION_idADS
            INNER JOIN HORARIO on idHORARIO=HORARIO_idHORARIO";
    }elseif ($table=="CONYUGE"){
    	$sql="SELECT * FROM CONYUGE";
    }
	$result = $mysqli->query($sql);
	//$count = 0;
	if($result->num_rows > 0){ /*no error*/
		if($table=="MORRO"){
			$res="<center><table class='table' style='background-color: white; border-radius: 1%; width: 88%'> <thead> <th> FOLIO </th> <th scope='col'> NOMBRE </th><th scope='col'><center> FOTO </center></th><th scope='col'> EDAD </th><th scope='col'> AMBOS PADRES? </th>  <th scope='col'> GRUPO </th> <th scope='col'> ENTREVISTA </th> <th scope='col'> CITA </th><th scope='col'> PERSONA AUTORIZADA </th></thead>";
			while($row = $result->fetch_assoc()) {
			//$count=$count+1;
			$bipater;
			$interv;
			$aut;
			if($row["2PADRES"]=="1"){$bipater="YES";}else{$bipater="NO";}
			if($row["DIA_ENTREVISTA"]==NULL){
				$interv="NO APLICA";
			}else{
				$interv=$row["DIA_ENTREVISTA"]." ".$row["HORA"];
			}
			if($row["FOTO_AUT"]==NULL){
				$aut="NO APLICA";
			}else{
				$aut="<img src='img/".$row["FOTO_AUT"]. "' width=75%/>";
			}
	    	$res=$res."<tr>
	    		<th scope=row><center> ". $row["FOLIO"]." </center></td>
	    		<td><center> " . $row["NOM_M"]." ".$row["APE_PAT"]." ".$row["APE_MAT"]. " </center></td>
	    		<td><center><img src='img/customerImages/" . $row["FOTO_M"]. ".png' width=75%/></center></td>
	    		<td><center>" .$row["EDAD"]. "</center></td> 
	    		<td><center>" .$bipater. "</center></td> 
	    		<td><center>" .$row["NOMBRE_G"]. "</center></td>
	    		<td><center>" .$row["DIA_CITA"]." ".$row["INICIO"]. "</center></td>
	    		<td><center>" .$interv. "</center></td>
	    		<td><center>" . $aut . " </center></td>
	    	  </tr>";
	  		}
	    }elseif ($table=="DERECHOHABIENTE") {
			$res="<center><table class='table' style='background-color: white; border-radius: 1%; width: 88%'> <thead> <th> FOLIO </th> <th scope='col'> NOMBRE </th><th scope='col'><center> FOTO </center></th><th scope='col'> DIRECCION </th><th scope='col'> OCUPACION </th><th scope='col'> PLAZA </th>  <th scope='col'> SUELDO </th> <th scope='col'> NUMERO DE EMPLEADO </th> <th scope='col'> ADSCRIPCION </th><th scope='col'> JEFE </th><th scope='col'> HORARIO </th><th scope='col'> TELEFONO CELULAR</th><th scope='col'> TELEFONO FIJO </th><th scope='col'> CURP </th><th scope='col'> MAIL </th></thead>";
			while($row = $result->fetch_assoc()) {
			$res=$res."<tr>
	    		<th scope=row><center> ". $row["MORRO_Boleta_D"]." </center></td>
	    		<td><center> " . $row["NOM_D"]." ".$row["APE_PAT_D"]." ".$row["APE_MAT_D"]. " </center></td>
	    		<td><center><img src='img/customerImages/" . $row["FOTO_D"]. "' width=75%/></center></td>
	    		<td><center>" .$row["CP_D"]." ".$row["ESTADO_D"]." ".$row["MUNICIPIO_D"]." ".$row["COLONIA_D"]." ".$row["NUM_EXT_D"]." ".$row["NUM_INT_D"]. "</center></td> 
	    		<td><center>" .$row["NOM_O"]. "</center></td> 
	    		<td><center>" .$row["PLAZA_D"]. "</center></td>
	    		<td><center>" .$row["SUELDO_D"]. "</center></td>
	    		<td><center>" .$row["NUMEROE_D"]. "</center></td>
	    		<td><center>" .$row["NOMBRE_ESC"]. "</center></td>
	    		<td><center>" .$row["NOMJEFE_D"]." ".$row["CARGOJEFE_D"]. "</center></td>
	    		<td><center>" .$row["HORA_E"]."-".$row["HORA_S"]. "</center></td>
	    		<td><center>" .$row["TELC_D"]." ". "</center></td>
	    		<td><center>" .$row["TELF_D"]." ".$row["EXT_D"]. "</center></td>
	    		<td><center>" .$row["CURP_D"]. "</center></td>
	    		<td><center>" .$row["MAIL_D"]. "</center></td>
	    	  </tr>";
	  		} 
			/**/
	    }elseif ($table=="CONYUGE"){
	    	$res= "<center><table class='table' style='background-color: white; border-radius: 1%; width: 88%'> <thead> <th> FOLIO </th> <th scope='col'> NOMBRE </th><th scope='col'><center> FOTO </center></th><th scope='col'> DIRECCION </th><th scope='col'> LUGAR DE TRABAJO </th>  <th scope='col'> TELEFONO TRABAJO </th> <th scope='col'> TELEFONO CASA </th> <th scope='col'> RELIGION </th></thead>";
	    	while($row = $result->fetch_assoc()) {
			$res=$res."<tr>
	    		<th scope=row><center> ". $row["MORRO_Boleta_C"]." </center></td>
	    		<td><center> " . $row["NOM_C"]." ".$row["APE_PAT_C"]." ".$row["APE_MAT_C"]. " </center></td>
	    		<td><center><img src='img/customerImages/" . $row["FOTO_C"]. "' width=75%/></center></td>
	    		<td><center>" .$row["CP_C"]." ".$row["ESTADO_C"]." ".$row["MUNICIPIO_C"]." ".$row["COLONIA_C"]." ".$row["NUM_EXT_C"]." ".$row["NUM_INT_C"]. "</center></td> 
	    		<td><center>" .$row["LUGART_C"]. "</center></td> 
	    		<td><center>" .$row["TELT_C"]." ".$row["EXT_C"]. "</center></td>
	    		<td><center>" .$row["TELC_C"]. "</center></td>
	    		<td><center>" .$row["RELIGION_C"]. "</center></td>";
	  		}    	/**/
	    }
  		$res=$res."</table></center></div>";
	}else{ /*error*/
		$res="BASE SIN DATOS";
	}
	echo $res;
?>