<?php
   /* require('fpdf184/fpdf.php');
    $pdf = new FPDF('P','mm','letter'); //Posicion de la hoja P vertical L hotizontal,Unidad de medida del usuiario(pt,cm,mm,in)
    $pdf->AddPage('P','letter',0); //Aqui se pueden revisar sus tamaños, tipo de hoja, y su rotacion
    $pdf->SetFont('Arial','B',18);//Fuente,negrita,tamaño
    $pdf->Cell(50,12,'Hola Mundo',1,0,'L');//ancho,alto,texto interno,1 se muestra borde,1 continuar en la linea,alineacion del texto (L,R,C),color
    $pdf->Cell(50,12,'Hola Mundo',1,1,'L');
    $pdf->Output('I');//(I envia al navegador,D envia a nav y lo descarga,F guarda el fichero en local con nombre,S devuelve el doc como una cadena DESTINO),('NOMBRE.pdf'),
    */
    include("phpMailer/class.phpmailer.php");
    include("phpMailer/class.smtp.php");
    require('fpdf184/fpdf.php');
    include 'conexion.php';
    // $bnum='2022013333';
    $bnum=$_GET['folio'];
    $morro ="SELECT * FROM MORRO 
	INNER JOIN CENDI on CENDI_idCENDI=idCENDI 
    INNER JOIN CITAS on CITAS_idCITAS=idCITAS 
    INNER JOIN ENTREVISTA on ENTREVISTA_idENTREVISTA=idENTREVISTA
    INNER JOIN GRUPO on GRUPO_idGRUPO=idGRUPO
    INNER JOIN (DERECHOHABIENTE 
					INNER JOIN OCUPACION on OCUPACION_ID=ID
                    INNER JOIN ADSCRIPCION on idADS=ADSCRIPCION_idADS
                    INNER JOIN HORARIO on idHORARIO=HORARIO_idHORARIO) on DERECHOHABIENTE.MORRO_Boleta_D=FOLIO
    INNER JOIN CONYUGE as CONYUGUE on CONYUGUE.MORRO_Boleta_C=FOLIO WHERE FOLIO='$bnum'";
    $res=mysqli_query($conexion,$morro);
    $datos=mysqli_fetch_assoc($res);
    
    /* //Select del morro
    $morro ="SELECT * FROM morro";
    $res=mysqli_query($conexion,$morro);
    $datos=mysqli_fetch_assoc($res);

    //Select del CENDI
    $idcendi=$datos['CENDI_idCENDI'];
    $cendi="SELECT * FROM cendi INNER JOIN morro ON CENDI_idCENDI = idCENDI  WHERE CENDI_idCENDI = '$idcendi'";
    $rescen=mysqli_query($conexion,$cendi);
    $datoscen=mysqli_fetch_assoc($rescen);

    //Select del derechohabiente
    $der ="SELECT * FROM derechohabiente";
    $resd=mysqli_query($conexion,$der);
    $datosd=mysqli_fetch_assoc($resd);

    //Select del conyuge
    $con ="SELECT * FROM conyuge";
    $resc=mysqli_query($conexion,$con);
    $datosc=mysqli_fetch_assoc($resc);
    $idg=$datos['GRUPO_idGRUPO'];

    //Select del grupo
    $gr="SELECT * FROM grupo INNER JOIN morro ON GRUPO_idGRUPO = idGRUPO WHERE idGRUPO = '$idg' ";
    $resg=mysqli_query($conexion,$gr);
    $datosg=mysqli_fetch_assoc($resg);

    //Select de la direccion derechohabiente
    $idd=$datosd['sepomex_id'];
    $dir="SELECT * FROM sepomex INNER JOIN derechohabiente ON sepomex_id = id WHERE sepomex_id = '$idd' ";
    $resdir=mysqli_query($conexion,$dir);
    $datosdir=mysqli_fetch_assoc($resdir);

    //Select de la direccion conyuge
    $idy=$datosc['sepomex_id'];
    $dirc="SELECT * FROM sepomex INNER JOIN conyuge ON sepomex_id = id WHERE sepomex_id = '$idy' ";
    $resdirc=mysqli_query($conexion,$dirc);
    $datosdirc=mysqli_fetch_assoc($resdirc);

    //Select de la ocupacion
    $ido=$datosd['OCUPACION_ID'];
    $oc="SELECT ocupacion.NOM FROM ocupacion INNER JOIN derechohabiente ON OCUPACION_ID = ID WHERE OCUPACION_ID = '$ido' ";
    $resoc=mysqli_query($conexion,$oc);
    $datosoc=mysqli_fetch_assoc($resoc);

    //Select de la adscripcion
    $idad=$datosd['OCUPACION_ID'];
    $ad="SELECT * FROM adscripcion INNER JOIN derechohabiente ON  ADSCRIPCION_idADS = idADS WHERE ADSCRIPCION_idADS = '$idad' ";
    $resad=mysqli_query($conexion,$ad);
    $datosad=mysqli_fetch_assoc($resad);

    //Select del horario de trabajo
    $idh=$datosd['HORARIO_idHORARIO'];
    $hor="SELECT * FROM horario INNER JOIN derechohabiente ON  HORARIO_idHORARIO =idHORARIO  WHERE HORARIO_idHORARIO = '$idh' ";
    $resh=mysqli_query($conexion,$hor);
    $datosh=mysqli_fetch_assoc($resh);

    //Select del horario de entrevista
    $iden=$datos['ENTREVISTA_idENTREVISTA'];
    $ent="SELECT * FROM entrevista INNER JOIN morro ON  ENTREVISTA_idENTREVISTA=idENTREVISTA  WHERE ENTREVISTA_idENTREVISTA = '$iden' ";
    $resent=mysqli_query($conexion,$ent);
    $datoent=mysqli_fetch_assoc($resent);
    
    //Select del horario de CITA
   /* $idcit=$datos['CITAS_idCITAS'];
    $cit="SELECT * FROM citas INNER JOIN morro ON  CITAS_idCITAS=idCITAS  WHERE CITAS_idCITAS = '$idcit' ";
    $rescit=mysqli_query($conexion,$cit);
    $datocit=mysqli_fetch_assoc($rescit);*/
    
   //Encabezado
    class PDF extends FPDF{
        function Header(){
            $this->Image('img/Lsep.png',10,10,40,0,'');
            $this->Image('img/Lipn.png',55,9,60,0,'');
            $this->Image('img/Lcdmx.png',150,10,60,20,'');
            
        }
    //Pie de pagina    
        function Footer(){
            $this->SetY(-18); //LA ordenada
            $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
            $this->SetFont('Arial','I',10);
            
        }
    }

    $pdf = new PDF('P','mm','letter');
    $pdf->SetFillColor(221,228,255);
    $pdf->AddPage('P','letter',0);
    $pdf->SetFont('Arial','B',15);
    $pdf->Ln(15);

    // Inicio del doc
    $pdf->Cell(198,12,utf8_decode('FICHA DE INSCRIPCIÓN'),0,1,'C');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(165,30,utf8_decode('CICLO ESCOLAR: 2022-2023'),0,0,'C');
    $pdf->Cell(30,30,$pdf->Image('img/customerImages/'.$datos["FOTO_M"],175,37,30,0,''),1,1,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(150,12,utf8_decode('CENDI:')." ".$datos["NOMBRE_CE"],0,0,'C');  
    $pdf->Cell(15,10,'Folio:',1,0,'C');
    $pdf->Cell(30,10,utf8_decode($datos["FOLIO"]),1,1,'C'); 
    $pdf->Cell(150,10,'',0,0,'C');
    $pdf->Cell(15,10,utf8_decode('Grupo:'),1,0,'C');
    $pdf->Cell(30,10,utf8_decode($datos["NOMBRE_G"]),1,1,'C');  
    // Fin primera seccion

    //Inicio seccion datos del niño o niña
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(66,7,utf8_decode('DATOS DEL NIÑO O DE LA NIÑA:'),0,1,'L'); 
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(66,5,utf8_decode($datos["APE_PAT"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["APE_MAT"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["NOM_M"]),1,1,'C',1);  
    $pdf->SetFont('Arial','',10); 
    $pdf->Cell(66,5,'Primer Apellido',1,0,'C',0); 
    $pdf->Cell(66,5,'Segundo Apellido',1,0,'C',0); 
    $pdf->Cell(66,5,'Nombre(s)',1,1,'C',0);
    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(66,5,utf8_decode($datos["FECHAN"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["EDAD"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["CURP"]),1,1,'C',1);
    $pdf->SetFont('Arial','',10); 
    $pdf->Cell(66,5,'Fecha de Nacimiento:',1,0,'C',0); 
    $pdf->Cell(66,5,'Edad:',1,0,'C',0); 
    $pdf->Cell(66,5,'CURP:',1,1,'C',0);
    // Fin seccion del niño o niña

    //Inicio derechohabiente
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(66,7,utf8_decode('DATOS DEL O LA DERECHOHABIENTE:'),0,1,'L'); 
    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(66,5,utf8_decode($datos["APE_PAT_D"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["APE_MAT_D"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["NOM_D"]),1,1,'C',1);  
    $pdf->SetFont('Arial','',10); 
    $pdf->Cell(66,5,'Primer Apellido',1,0,'C',0); 
    $pdf->Cell(66,5,'Segundo Apellido',1,0,'C',0); 
    $pdf->Cell(66,5,'Nombre(s)',1,1,'C',0);

    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(33,5,utf8_decode($datos["CP_D"]),1,0,'C',1); 
    $pdf->Cell(33,5,utf8_decode($datos["ESTADO_D"]),1,0,'C',1); 
    $pdf->Cell(33,5,utf8_decode($datos["MUNICIPIO_D"]),1,0,'C',1);
    $pdf->Cell(33,5,utf8_decode($datos["COLONIA_D"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["CALLE_D"]),1,1,'C',1); 
    $pdf->SetFont('Arial','',10); 
    $pdf->Cell(33,5,'C.P.',1,0,'C',0); 
    $pdf->Cell(33,5,'Entidad',1,0,'C',0); 
    $pdf->Cell(33,5,'Alcaldia',1,0,'C',0);
    $pdf->Cell(33,5,'Colonia',1,0,'C',0); 
    $pdf->Cell(66,5,'Calle',1,1,'C',0);

    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(33,5,utf8_decode($datos["NUM_EXT_D"]),1,0,'C',1); 
    $pdf->Cell(33,5,utf8_decode($datos["NUM_INT_D"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["TELF_D"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["TELC_C"]),1,1,'C',1); 
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(33,5,utf8_decode('N°Ext.'),1,0,'C',0); 
    $pdf->Cell(33,5,utf8_decode('N°int.'),1,0,'C',0);
    $pdf->Cell(66,5,utf8_decode('Teléfono Fijo'),1,0,'C',0); 
    $pdf->Cell(66,5,utf8_decode('Teléfono Celular'),1,1,'C',0);

    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(66,5,utf8_decode($datos["MAIL_D"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["NOM_O"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["CURP_D"]),1,1,'C',1); 
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(66,5,utf8_decode('Correo Electrónico'),1,0,'C',0); 
    $pdf->Cell(66,5,utf8_decode('Ocupación'),1,0,'C',0);
    $pdf->Cell(66,5,'CURP',1,1,'C',0); 

    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(66,5,utf8_decode($datos["PLAZA_D"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["SUELDO_D"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["NUMEROE_D"]),1,1,'C',1); 
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(66,5,utf8_decode('Puesto'),1,0,'C',0); 
    $pdf->Cell(66,5,utf8_decode('Sueldo Mensual'),1,0,'C',0);
    $pdf->Cell(66,5,utf8_decode('Número de empleado'),1,1,'C',0); 
    
    $pdf->SetFont('Arial','B',10);  
    $pdf->Cell(198,5,utf8_decode($datos["NOMBRE_ESC"]),1,1,'C',1);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(198,5,utf8_decode('Adscripción'),1,1,'C',0); 
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(132,5,utf8_decode($datos["HORA_E"]."AM - ".$datos["HORA_S"]."PM"),1,0,'C',1);
    $pdf->Cell(66,5,utf8_decode($datos["EXT_D"]),1,1,'C',1); 
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(132,5,utf8_decode('Horario de trabajo'),1,0,'C',0); 
    $pdf->Cell(66,5,utf8_decode('Extensión'),1,1,'C',0);
    //FIn derechohabiente

    if($datos["2PADRES"]==1){// VAlidacion si hay o no conyuge
        // INICIO CONYUGE
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(66,7,utf8_decode('DATOS DEL CÓNYUGE(PADRE,MADRE):'),0,1,'L'); 
    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(66,5,utf8_decode($datos["APE_PAT_C"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["APE_MAT_C"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["NOM_C"]),1,1,'C',1);  
    $pdf->SetFont('Arial','',10); 
    $pdf->Cell(66,5,'Primer Apellido',1,0,'C',0); 
    $pdf->Cell(66,5,'Segundo Apellido',1,0,'C',0); 
    $pdf->Cell(66,5,'Nombre(s)',1,1,'C',0);
     
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(33,5,utf8_decode($datos["CP_C"]),1,0,'C',1); 
    $pdf->Cell(33,5,utf8_decode($datos["ESTADO_C"]),1,0,'C',1); 
    $pdf->Cell(33,5,utf8_decode($datos["MUNICIPIO_C"]),1,0,'C',1); 
    $pdf->Cell(33,5,utf8_decode($datos["COLONIA_C"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["CALLE_C"]),1,1,'C',1); 
    $pdf->SetFont('Arial','',10); 
    $pdf->Cell(33,5,'C.P.',1,0,'C',0); 
    $pdf->Cell(33,5,'Entidad',1,0,'C',0); 
    $pdf->Cell(33,5,'Alcaldia',1,0,'C',0);
    $pdf->Cell(33,5,'Colonia',1,0,'C',0); 
    $pdf->Cell(66,5,'Calle',1,1,'C',0);

    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(33,5,utf8_decode($datos["NUM_EXT_C"]),1,0,'C',1); 
    $pdf->Cell(33,5,utf8_decode($datos["NUM_INT_C"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["TELC_C"]),1,0,'C',1); 
    $pdf->Cell(66,5,utf8_decode($datos["TELC_C"]),1,1,'C',1); 
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(33,5,utf8_decode('N°Ext.'),1,0,'C',0); 
    $pdf->Cell(33,5,utf8_decode('N°int.'),1,0,'C',0);
    $pdf->Cell(66,5,utf8_decode('Teléfono Fijo'),1,0,'C',0); 
    $pdf->Cell(66,5,utf8_decode('Teléfono Celular'),1,1,'C',0);

    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(198,5,utf8_decode($datos["LUGART_C"]),1,1,'C',1);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(198,5,'Lugar de Trabajo:',1,1,'C',0);
    $pdf->SetFont('Arial','B',10);  
    $pdf->Cell(198,5,utf8_decode($datos["DOMT_C"]),1,1,'C',1); 
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(198,5,'Domicilio de Trabajo:',1,1,'C',0);
    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(99,5,utf8_decode($datos["TELT_C"]),1,0,'C',1); 
    $pdf->Cell(33,5,utf8_decode($datos["EXT_C"]),1,0,'C',1);
    $pdf->Cell(66,5,utf8_decode($datos["RELIGION_C"]),1,1,'C',1);  
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(99,5,utf8_decode('Teléfono de Trabajo'),1,0,'C',0); 
    $pdf->Cell(33,5,utf8_decode('Extensión'),1,0,'C',0);
    $pdf->Cell(66,5,utf8_decode('Religión'),1,1,'C',0);

    }else{  // SI no hay conyuge
        // INICIO CONYUGE
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(66,7,utf8_decode('DATOS DEL CÓNYUGE(PADRE,MADRE):'),0,1,'L'); 
    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(66,5,"",1,0,'C',1); 
    $pdf->Cell(66,5,"",1,0,'C',1); 
    $pdf->Cell(66,5,"",1,1,'C',1);  
    $pdf->SetFont('Arial','',10); 
    $pdf->Cell(66,5,'Primer Apellido',1,0,'C',0); 
    $pdf->Cell(66,5,'Segundo Apellido',1,0,'C',0); 
    $pdf->Cell(66,5,'Nombre(s)',1,1,'C',0);
     
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(33,5,"",1,0,'C',1); 
    $pdf->Cell(33,5,"",1,0,'C',1); 
    $pdf->Cell(33,5,"",1,0,'C',1); 
    $pdf->Cell(33,5,"",1,0,'C',1); 
    $pdf->Cell(66,5,"",1,1,'C',1); 
    $pdf->SetFont('Arial','',10); 
    $pdf->Cell(33,5,'C.P.',1,0,'C',0); 
    $pdf->Cell(33,5,'Entidad',1,0,'C',0); 
    $pdf->Cell(33,5,'Alcaldia',1,0,'C',0);
    $pdf->Cell(33,5,'Colonia',1,0,'C',0); 
    $pdf->Cell(66,5,'Calle',1,1,'C',0);

    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(33,5,"",1,0,'C',1); 
    $pdf->Cell(33,5,"",1,0,'C',1); 
    $pdf->Cell(66,5,"",1,0,'C',1); 
    $pdf->Cell(66,5,"",1,1,'C',1); 
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(33,5,utf8_decode('N°Ext.'),1,0,'C',0); 
    $pdf->Cell(33,5,utf8_decode('N°int.'),1,0,'C',0);
    $pdf->Cell(66,5,utf8_decode('Teléfono Fijo'),1,0,'C',0); 
    $pdf->Cell(66,5,utf8_decode('Teléfono Celular'),1,1,'C',0);

    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(198,5,"",1,1,'C',1);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(198,5,'Lugar de Trabajo:',1,1,'C',0);
    $pdf->SetFont('Arial','B',10);  
    $pdf->Cell(198,5,"",1,1,'C',1); 
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(198,5,'Domicilio de Trabajo:',1,1,'C',0);
    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(99,5,"",1,0,'C',1); 
    $pdf->Cell(33,5,"",1,0,'C',1);
    $pdf->Cell(66,5,"",1,1,'C',1);  
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(99,5,utf8_decode('Teléfono de Trabajo'),1,0,'C',0); 
    $pdf->Cell(33,5,utf8_decode('Extensión'),1,0,'C',0);
    $pdf->Cell(66,5,utf8_decode('Religión'),1,1,'C',0);
    }
    
    if( file_exists('img/customerImages/'.$datos["FOTO_AUT"]) && $datos["2PADRES"]==1){
        $pdf->AddPage('P','letter',0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Ln(30);
        $pdf->Cell(198,12,utf8_decode('FOTOGRAFÍAS DEL O LA DERECHOHABIENTE,CÓNYUGE(PADRE,MADRE) Y PERSONA AUTORIZADA PARA RECOGER AL NIÑO O A LA NIÑA'),0,1,'C');
        $pdf->Ln(10);
        $pdf->Cell(25,30,'',0,0,'C');
        $pdf->Cell(30,30,$pdf->Image('img/customerImages/'.$datos["FOTO_D"],35,62,30,0,''),1,0,'C');
        $pdf->Cell(30,30,'',0,0,'C');
        $pdf->Cell(30,30,$pdf->Image('img/customerImages/'.$datos["FOTO_C"],95,62,30,0,''),1,0,'C');
        $pdf->Cell(30,30,'',0,0,'C');
        $pdf->Cell(30,30,$pdf->Image('img/customerImages/'.$datos["FOTO_AUT"],155,62,30,0,''),1,1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',12); 
        $pdf->Cell(25,5,'',0,0,'C');
        $pdf->Cell(30,5,'DERECHOHABIENTE',0,0,'C');
        $pdf->Cell(30,5,'',0,0,'C');
        $pdf->Cell(30,5,utf8_decode('CÓNYUGE'),0,0,'C');
        $pdf->Cell(30,5,'',0,0,'C');
        $pdf->Cell(30,5,'PERSONA AUTORIZADA',0,1,'C');
        $pdf->Cell(25,5,'',0,0,'C');
        $pdf->Cell(30,5,'',0,0,'C');
        $pdf->Cell(30,5,'',0,0,'C');
        
    }else if(file_exists('img/customerImages/'.$datos["FOTO_AUT"]) && $datos["2PADRES"]==0){
        $pdf->AddPage('P','letter',0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Ln(30);
        $pdf->Cell(198,12,utf8_decode('FOTOGRAFÍAS DEL O LA DERECHOHABIENTE Y PERSONA AUTORIZADA'),0,1,'C');
        $pdf->Ln(10);
        $pdf->Cell(25,30,'',0,0,'C');
        $pdf->Cell(30,30,$pdf->Image('img/customerImages/'.$datos["FOTO_D"],35,62,30,0,''),1,0,'C');
        $pdf->Cell(88,30,'',0,0,'C');
        $pdf->Cell(30,30,$pdf->Image('img/customerImages/'.$datos["FOTO_AUT"],153,62,30,0,''),1,1,'C');
        
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',12); 
        $pdf->Cell(25,5,'',0,0,'C');
        $pdf->Cell(30,5,'DERECHOHABIENTE',0,0,'C');
        $pdf->Cell(88,5,'',0,0,'C');
        $pdf->Cell(30,5,utf8_decode('PERSONA RESPONSABLE'),0,0,'C');
        $pdf->Cell(30,5,'',0,0,'C');
        
        $pdf->Cell(25,5,'',0,0,'C');
        $pdf->Cell(30,5,'',0,0,'C');
        $pdf->Cell(30,5,'',0,0,'C');
       
    }else if(!file_exists('img/customerImages/'.$datos["FOTO_AUT"]) && $datos["2PADRES"]==1){

        $pdf->AddPage('P','letter',0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Ln(30);
        $pdf->Cell(198,12,utf8_decode('FOTOGRAFÍAS DEL O LA DERECHOHABIENTE Y CÓNYUGE(PADRE,MADRE)'),0,1,'C');
        $pdf->Ln(10);
        $pdf->Cell(25,30,'',0,0,'C');
        $pdf->Cell(30,30,$pdf->Image('img/customerImages/'.$datos["FOTO_D"],35,62,30,0,''),1,0,'C');
        $pdf->Cell(88,30,'',0,0,'C');
        $pdf->Cell(30,30,$pdf->Image('img/customerImages/'.$datos["FOTO_C"],153,62,30,0,''),1,1,'C');
        
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',12); 
        $pdf->Cell(25,5,'',0,0,'C');
        $pdf->Cell(30,5,'DERECHOHABIENTE',0,0,'C');
        $pdf->Cell(88,5,'',0,0,'C');
        $pdf->Cell(30,5,utf8_decode('CONYUGE'),0,0,'C');
        $pdf->Cell(30,5,'',0,0,'C');
        
        $pdf->Cell(25,5,'',0,0,'C');
        $pdf->Cell(30,5,'',0,0,'C');
        $pdf->Cell(30,5,'',0,0,'C');
    }else if($datos["2PADRES"]==0){
        $pdf->AddPage('P','letter',0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Ln(30);
        $pdf->Cell(198,12,utf8_decode('FOTOGRAFÍA DEL O LA DERECHOHABIENTE'),0,1,'C');
        $pdf->Ln(10);
        $pdf->Cell(84,30,'',0,0,'C');
        $pdf->Cell(30,30,$pdf->Image('img/customerImages/'.$datos["FOTO_D"],94,62,30,0,''),1,1,'C');
        
        
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',12); 
        $pdf->Cell(84,5,'',0,0,'C');
        $pdf->Cell(30,5,'DERECHOHABIENTE',0,0,'C');
       
        
        
        $pdf->Cell(25,5,'',0,0,'C');
        $pdf->Cell(30,5,'',0,0,'C');
        $pdf->Cell(30,5,'',0,0,'C');
    }
    
    if($datos["GRUPO_idGRUPO"]==1){

        $pdf->SetFont('Arial','B',12);
        $pdf->Ln(5);
        $pdf->Cell(198,12,utf8_decode('Presentarse a la entevista el día'),0,1,'L');
        $pdf->Cell(66,12,utf8_decode('Ciudad de México a '),0,0,'R');
        $pdf->Cell(14,12,date("d")+1,0,0,'C',1);
        $pdf->Cell(15,12,utf8_decode('de'),0,0,'C');
        $pdf->Cell(25,12,date("m"),0,0,'C',1);
        $pdf->Cell(15,12,utf8_decode('de'),0,0,'C');
        $pdf->Cell(25,12,date("Y"),0,1,'C',1);
        $pdf->Cell(198,12,utf8_decode('A las:'),0,1,'L');
        $pdf->Cell(66,12,'',0,0,'C',0);
        $pdf->Cell(66,12,utf8_decode("Inicio: ".$datos["INICIO"]." Fin ".$datos["FIN"]),0,0,'C',1);
        $pdf->Cell(66,12,'Hrs.',0,1,'L',0);
        
        
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(198,12,utf8_decode('Presentarse a la entrega de papeles el día'),0,1,'L');
        $pdf->Cell(66,12,utf8_decode('Ciudad de México a '),0,0,'R');
        $pdf->Cell(14,12,date("d")+1,0,0,'C',1);
        $pdf->Cell(15,12,utf8_decode('de'),0,0,'C');
        $pdf->Cell(25,12,date("m"),0,0,'C',1);
        $pdf->Cell(15,12,utf8_decode('de'),0,0,'C');
        $pdf->Cell(25,12,date("Y"),0,1,'C',1);
        $pdf->Cell(198,12,utf8_decode('A las:'),0,1,'L');
        $pdf->Cell(66,12,'',0,0,'C',0);
        $pdf->Cell(66,12,utf8_decode($datos["HORA"]),0,0,'C',1);
        $pdf->Cell(66,12,'Hrs.',0,1,'L',0);
        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(198,12,utf8_decode('Expedido el día:'),0,1,'L');
        $pdf->Cell(66,12,utf8_decode('Ciudad de México a '),0,0,'R');
        $pdf->Cell(14,12,date("d"),0,0,'C',1);
        $pdf->Cell(15,12,utf8_decode('de'),0,0,'C');
        $pdf->Cell(25,12,date("m"),0,0,'C',1);
        $pdf->Cell(15,12,utf8_decode('de'),0,0,'C');
        $pdf->Cell(25,12,date("Y"),0,1,'C',1);
        
    }else{
        $pdf->SetFont('Arial','B',12);
        $pdf->Ln(5);
        $pdf->Cell(198,12,utf8_decode('Presentarse a la entrega de papeles el día'),0,1,'L');
        $pdf->Cell(66,12,utf8_decode('Ciudad de México a '),0,0,'R');
        $pdf->Cell(14,12,date("d")+1,0,0,'C',1);
        $pdf->Cell(15,12,utf8_decode('de'),0,0,'C');
        $pdf->Cell(25,12,date("m"),0,0,'C',1);
        $pdf->Cell(15,12,utf8_decode('de'),0,0,'C');
        $pdf->Cell(25,12,date("Y"),0,1,'C',1);
        $pdf->Cell(198,12,utf8_decode('A las:'),0,1,'L');
        $pdf->Cell(66,12,'',0,0,'C',0);
        $pdf->Cell(66,12,utf8_decode(utf8_decode($datos["HORA"])),0,0,'C',1);
        $pdf->Cell(66,12,'Hrs.',0,1,'L',0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(198,12,utf8_decode('Expedido el día:'),0,1,'L');
        $pdf->Cell(66,12,utf8_decode('Ciudad de México a '),0,0,'R');
        $pdf->Cell(14,12,date("d"),0,0,'C',1);
        $pdf->Cell(15,12,utf8_decode('de'),0,0,'C');
        $pdf->Cell(25,12,date("m"),0,0,'C',1);
        $pdf->Cell(15,12,utf8_decode('de'),0,0,'C');
        $pdf->Cell(25,12,date("Y"),0,1,'C',1);
        
    }
    
    
   
    $pdf->Cell(66,12,'',0,0,'C',0);
    $pdf->Cell(66,12,'',0,1,'C',0);
    $pdf->Cell(66,12,'',0,0,'C',0);
    $pdf->Cell(66,12,utf8_decode($datos["APE_PAT_D"])." ".utf8_decode($datos["APE_MAT_D"])." ".utf8_decode($datos["NOM_D"]),'B',1,'C',0);

    $pdf->Cell(66,8,'',0,0,'C',0);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(66,8,'Nombre y Firma del derechohabiente',0,1,'C',0);

    $pdf->AliasNbPages();
    $pdf->Output('I','Ficha_de_inscripcion.pdf');
    $doc = $pdf->Output('S','Ficha_de_inscripcion.pdf');

        //ENvio a correo
        $email_user = "tecwebproyectcendi@gmail.com"; //OJO. Debes actualizar esta línea con tu información
        $email_password = "sjnvyzumxjcrzboq"; //OJO. Debes actualizar esta línea con tu información
        // $email_password = "esdrasEsGay69"; //OJO. Debes actualizar esta línea con tu información
        $the_subject = "Prueba de envio de PDF";
        $address_to = $datos["MAIL_D"]; //OJO. Debes actualizar esta línea con tu información
        $from_name = "PDF - Registro CENDI";
        $phpmailer = new PHPMailer();

        // ---------- datos de la cuenta de Gmail -------------------------------
        $phpmailer->Username = $email_user;
        $phpmailer->Password = $email_password; 
        //-----------------------------------------------------------------------
        // $phpmailer->SMTPDebug = 1;
        $phpmailer->SMTPSecure = 'tls';
        $phpmailer->Host = "smtp.gmail.com"; // GMail
        $phpmailer->Port = 587;
        $phpmailer->IsSMTP(); // use SMTP
        $phpmailer->SMTPAuth = true;

        $phpmailer->setFrom($phpmailer->Username,$from_name);
        $phpmailer->AddAddress($address_to); // recipients email

        $phpmailer->Subject = $the_subject;	
        $phpmailer->Body .="<h1 style='color:#3498db;'>Correo Con PDF proceso Inscripcion</h1>";
        $phpmailer->Body .= "<p>Esta es una prueba del envío de correo :)</p>";
        $phpmailer->Body .= "<p>Fecha: ".date("d-m-Y")."</p>";
        $phpmailer->AddStringAttachment($doc,"Ficha_de_inscripcion.pdf");
        $phpmailer->IsHTML(true);

        $phpmailer->Send();
 ?>
