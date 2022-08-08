<?php
    
    $fol = $_POST['fol']; 
    //echo $fol;
    $mysqli = new mysqli("localhost", "root", "", "dbtecweb");
	if ($mysqli->connect_errno) {
    	//echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}else{
		//echo "coneccion exitosa <br/>";
	}
    $sql = "SELECT * FROM MORRO 
            INNER JOIN CENDI on CENDI_idCENDI=idCENDI 
            INNER JOIN CITAS on CITAS_idCITAS=idCITAS 
            INNER JOIN ENTREVISTA on ENTREVISTA_idENTREVISTA=idENTREVISTA
            INNER JOIN GRUPO on GRUPO_idGRUPO=idGRUPO
            INNER JOIN (DERECHOHABIENTE 
                            INNER JOIN OCUPACION on OCUPACION_ID=ID
                            INNER JOIN ADSCRIPCION on idADS=ADSCRIPCION_idADS
                            INNER JOIN HORARIO on idHORARIO=HORARIO_idHORARIO) on DERECHOHABIENTE.MORRO_Boleta_D=FOLIO where FOLIO = $fol";
	$result = $mysqli->query($sql);
    $bipater=FALSE;
    if($result->num_rows > 0){
        //echo "SUCCESS";
        while($row = $result->fetch_assoc()){
            $data["FOLIO"]=$row["FOLIO"];
            $data["CENDI"]=$row["idCENDI"];
            $data["APE_PAT_M"]=$row["APE_PAT"];
            $data["APE_MAT_M"]=$row["APE_MAT"];
            $data["NOM_M"]=$row["NOM_M"];
            $data["FECHAN"]=$row["FECHAN"];
            $data["EDAD"]=$row["EDAD"];
            $data["CURP"]=$row["CURP"];
            $data["PADRES"]=$row["2PADRES"];
            $data["FOTO_M"]=$row["FOTO_M"];
            $data["GRUPO"]=$row["GRUPO_idGRUPO"];
            //$data["CITA"]=$row["HORA"];
            //$data["ENTREVISTAI"]=$row["INICIO"];
            $data["ENTREVISTAF"]=$row["FIN"];
            $data["AUTORIZADO"]=$row["FOTO_AUT"];
            $data["APE_PAT_D"]=$row["APE_PAT_D"];
            $data["APE_MAT_D"]=$row["APE_MAT_D"];
            //$data["FOTO_D"]=$row["FOTO_D"];
            $data["NOM_D"]=$row["NOM_D"];
            $data["NUM_EXT_D"]=$row["NUM_EXT_D"];
            $data["NUM_INT_D"]=$row["NUM_INT_D"];
            $data["CALLE_D"]=$row["CALLE_D"];
            $data["TELF_D"]=$row["TELF_D"];
            $data["TELC_D"]=$row["TELC_D"];
            $data["MAIL_D"]=$row["MAIL_D"];
            $data["OCUPACION"]=$row["OCUPACION_ID"];
            $data["ADSCRIPCION"]=$row["ADSCRIPCION_idADS"];
            $data["PLAZA_D"]=$row["PLAZA_D"];
            $data["SUELDO_D"]=$row["SUELDO_D"];
            $data["NUMEROE_D"]=$row["NUMEROE_D"];
            $data["NOMJEFE_D"]=$row["NOMJEFE_D"];
            $data["CARGOJEFE_D"]=$row["CARGOJEFE_D"];
            $data["HORARIO"]=$row["HORARIO_idHORARIO"];
            $data["EXT_D"]=$row["EXT_D"];
            $data["COLONIA_D"]=$row["COLONIA_D"];
            $data["MUNICIPIO_D"]=$row["MUNICIPIO_D"];
            $data["ESTADO_D"]=$row["ESTADO_D"];
            $data["COLONIA_D"]=$row["COLONIA_D"];
            $data["CP_D"]=$row["CP_D"];
            $data["CURP_D"]=$row["CURP_D"];
        }
        if($data["PADRES"]==1){
            $sql = "SELECT * FROM  CONYUGE  where MORRO_Boleta_C=$fol";
            $result2 = $mysqli->query($sql);
            if($result2->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $data["NOM_C"]=$row["NOM_C"];
                    $data["APE_PAT_C"]=$row["APE_PAT_C"];
                    $data["APE_MAT_C"]=$row["APE_MAT_C"];
                    $data["FOTO_C"]=$row["FOTO_C"];
                    $data["CALLE_C"]=$row["CALLE_C"];
                    $data["NUM_INT_C"]=$row["NUM_INT_C"];
                    $data["NUM_EXT_C"]=$row["NUM_EXT_C"];
                    $data["LUGART_C"]=$row["LUGART_C"];
                    $data["DOMT_C"]=$row["DOMT_C"];
                    $data["TELT_C"]=$row["TELT_C"];
                    $data["TELC_C"]=$row["TELC_C"];
                    $data["RELIGION_C"]=$row["RELIGION_C"];
                    $data["EXT_C"]=$row["EXT_C"];
                    $data["COLONIA_C"]=$row["COLONIA_C"];
                    $data["MUNICIPIO_C"]=$row["MUNICIPIO_C"];
                    $data["ESTADO_C"]=$row["ESTADO_C"];
                    $data["CP_C"]=$row["CP_C"];
                }
            }   
        }
    }else{
        //echo "error";
    }

    echo json_encode($data);
?>
