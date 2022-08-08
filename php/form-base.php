<?php

    include 'conexion.php';
    $folio=$_POST['folio'];

    session_start();
    $_SESSION['folio']=$folio;

    // Niño datos:

    $cendi=$_POST['cendi'];
    $kid_img=$_POST['kid_img'];
    $kid_apellido_pat=$_POST['kid_apellido_pat'];
    $kid_apellido_mat=$_POST['kid_apellido_mat'];
    $kid_nombres=$_POST['kid_nombres'];
    $kid_birthday=$_POST['kid_birthday'];
    $kid_age=$_POST['kid_age'];
    $kid_CURP=$_POST['kid_CURP'];
    $kid_dos_padres=$_POST['kid_dos_padres'];
    $kid_cita=$_POST['kid_cita'];
    $kid_entrevista=$_POST['kid_entrevista'];
    $kid_grupo=$_POST['kid_grupo'];
    $kid_dia_cita=NULL; //cambiar
    $kid_dia_entrevista=NULL; //cambiar
    $resp_img=$_POST['resp_img'];

    // Derechohabiente datos:

    $der_img=$_POST['der_img'];
    $der_apellido_pat=$_POST['der_apellido_pat'];
    $der_apellido_mat=$_POST['der_apellido_mat'];
    $der_nombres=$_POST['der_nombres'];
    $der_cp=$_POST['der_cp'];
    $der_entidad=$_POST['der_entidad'];
    $der_alcaldia=$_POST['der_alcaldia'];
    $der_colonia=$_POST['der_colonia'];
    $der_calle=$_POST['der_calle'];
    $der_numExt=$_POST['der_numExt'];
    $der_numInt=$_POST['der_numInt'];
    $der_tel_fijo=$_POST['der_tel_fijo'];
    $der_tel_celular=$_POST['der_tel_celular'];
    $der_email=$_POST['der_email'];
    $der_CURP=$_POST['der_CURP'];
    $der_ocupacion=$_POST['der_ocupacion'];
    $der_plaza=$_POST['der_plaza'];
    $der_sueldo=$_POST['der_sueldo'];
    $der_numEmpleado=$_POST['der_numEmpleado'];
    $der_adscripcion=$_POST['der_adscripcion'];
    $der_jefe=$_POST['der_jefe'];
    $der_jefe_puesto=$_POST['der_jefe_puesto'];
    $der_horario=$_POST['der_horario'];
    $der_extension=$_POST['der_extension'];

    // Conyuge Datos

    $cony_img=$_POST['cony_img'];
    $cony_apellido_pat=$_POST['cony_apellido_pat'];
    $cony_apellido_mat=$_POST['cony_apellido_mat'];
    $cony_nombres=$_POST['cony_nombres'];
    $cony_cp=$_POST['cony_cp'];
    $cony_entidad=$_POST['cony_entidad'];
    $cony_alcaldia=$_POST['cony_alcaldia'];
    $cony_colonia=$_POST['cony_colonia'];
    $cony_calle=$_POST['cony_calle'];
    $cony_numExt=$_POST['cony_numExt'];
    $cony_numInt=$_POST['cony_numInt'];
    $cony_tel_fijo=$_POST['cony_tel_fijo'];
    $cony_tel_celular=$_POST['cony_tel_celular'];
    $cony_lugar_trabajo=$_POST['cony_lugar_trabajo'];
    $cony_domicilio_trabajo=$_POST['cony_domicilio_trabajo'];
    $cony_tel_trabajo=$_POST['cony_tel_trabajo'];
    $cony_extension=$_POST['cony_extension'];
    $cony_si=$_POST['cony_si'];
    $cony_religion=$_POST['cony_religion'];

    $sql_n="INSERT INTO `DBTECWEB`.`MORRO` (`FOLIO`, `CENDI_idCENDI`, `APE_PAT`, `APE_MAT`, `NOM_M`, `FECHAN`, `EDAD`, `CURP`, `FOTO_M`, `2PADRES`, `CITAS_idCITAS`, `ENTREVISTA_idENTREVISTA`, `GRUPO_idGRUPO`, `DIA_CITA`, `DIA_ENTREVISTA`,`FOTO_AUT`) VALUES ('$folio', '$cendi', '$kid_apellido_pat', '$kid_apellido_mat', '$kid_nombres', '$kid_birthday', '$kid_age', '$kid_CURP', '$kid_img', '$kid_dos_padres', '$kid_cita', '$kid_entrevista', '$kid_grupo','$kid_dia_cita','$kid_dia_entrevista','$resp_img')";
    $sql_d="INSERT INTO `DBTECWEB`.`DERECHOHABIENTE` (`MORRO_Boleta_D`, `APE_PAT_D`, `APE_MAT_D`,`FOTO_D`, `NOM_D`, `NUM_EXT_D`, `NUM_INT_D`, `CALLE_D`, `TELF_D`, `TELC_D`, `MAIL_D`, `OCUPACION_ID`, `CURP_D`, `PLAZA_D`, `SUELDO_D`, `NUMEROE_D`, `ADSCRIPCION_idADS`, `NOMJEFE_D`, `CARGOJEFE_D`, `HORARIO_idHORARIO`, `EXT_D`, `COLONIA_D`, `MUNICIPIO_D`, `ESTADO_D`, `CP_D`) VALUES ('$folio', '$der_apellido_pat', '$der_apellido_mat','$der_img', '$der_nombres','$der_numExt','$der_numInt', '$der_calle', '$der_tel_fijo', '$der_tel_celular', '$der_email', '$der_ocupacion', '$der_CURP', '$der_plaza', '$der_sueldo', '$der_numEmpleado', '$der_adscripcion', '$der_jefe', '$der_jefe_puesto', '$der_horario', '$der_extension', '$der_colonia', '$der_alcaldia', '$der_entidad', '$der_cp')";
    $sql_c="INSERT INTO `DBTECWEB`.`CONYUGE` (`MORRO_Boleta_C`, `APE_PAT_C`, `APE_MAT_C`,`NOM_C`,`FOTO_C`, `CALLE_C`, `NUM_INT_C`, `NUM_EXT_C`, `LUGART_C`, `DOMT_C`, `TELT_C`, `TELC_C`, `RELIGION_C`, `EXT_C`, `COLONIA_C`, `MUNICIPIO_C`, `ESTADO_C`, `CP_C`) VALUES ('$folio', '$cony_apellido_pat', '$cony_apellido_mat', '$cony_nombres','$cony_img', '$cony_calle', '$cony_numInt', '$cony_numExt', '$cony_lugar_trabajo', '$cony_domicilio_trabajo', '$cony_tel_trabajo', '$cony_tel_celular', '$cony_religion', '$cony_extension', '$cony_colonia', '$cony_alcaldia', '$cony_entidad', '$cony_cp')";

    $res_n = mysqli_query($conexion,$sql_n);
    $res_d = mysqli_query($conexion,$sql_d);
    
    // echo $res_d;
    echo mysqli_query($conexion,$sql_c);
    

    

?>