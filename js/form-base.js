// alert("hola");

$(document).ready(function(){
    $("#formulario-prin").submit(function(e){
        e.preventDefault();       

        var folio = $("#folio").val();
        var cendi = $("#CENDI").val();
        var kid_img = folio+"_0.png";
        var kid_apellido_pat = $("#kid_apellido_pat").val();
        var kid_apellido_mat = $("#kid_apellido_mat").val();
        var kid_nombres = $("#kid_nombres").val();
        var kid_birthday = $("#kid_birthday").val();
        var kid_age = $("#kid_age").val();
        var kid_CURP = $("#kid_CURP").val();
        var kid_dos_padres;
        if(document.getElementById("der_cony_si").checked){
            kid_dos_padres = 1;
        }else{
            kid_dos_padres = 0;
        }
        var kid_cita = 1;
        var kid_entrevista = 1;
        var kid_grupo = $("#grupo").val();
        var resp_img = folio+"_2.png";

        // Datos del derechohabiente

        var der_img = folio+"_1.png";
        var der_apellido_pat = $("#der_apellido_pat").val();
        var der_apellido_mat = $("#der_apellido_mat").val();
        var der_nombres = $("#der_nombres").val();
        var der_cp = $("#der_cp").val();
        var der_entidad = $("#der_entidad").val();
        var der_alcaldia = $("#der_alcaldia").val();
        var der_colonia = $("#der_colonia").val();
        var der_calle = $("#der_calle").val();
        var der_numExt = $("#der_numExt").val();
        var der_numInt = $("#der_numInt").val();
        var der_tel_fijo = $("#der_tel_fijo").val();
        var der_tel_celular = $("#der_tel_celular").val();
        var der_email = $("#der_email").val();
        var der_CURP = $("#der_CURP").val();
        var der_ocupacion = $("#der_ocupacion").val();
        var der_plaza = $("#der_plaza").val();
        var der_sueldo = $("#der_sueldo").val();
        var der_numEmpleado = $("#der_numEmpleado").val();
        var der_adscripcion = $("#der_adscripcion").val();
        var der_jefe = $("#der_jefe").val();
        var der_jefe_puesto = $("#der_jefe_puesto").val();
        var der_horario = $("#der_horario").val();
        var der_extension = $("#der_extension").val();

        // Datos del conyuge

        var cony_img = folio+"_3.png";
        var cony_apellido_pat = $("#cony_apellido_pat").val();
        var cony_apellido_mat = $("#cony_apellido_mat").val();
        var cony_nombres = $("#cony_nombres").val();
        var cony_cp = $("#cony_cp").val();
        var cony_entidad = $("#cony_entidad").val();
        var cony_alcaldia = $("#cony_alcaldia").val();
        var cony_colonia = $("#cony_colonia").val();
        var cony_calle = $("#cony_calle").val();
        var cony_numExt = $("#cony_numExt").val();
        var cony_numInt = $("#cony_numInt").val();
        var cony_tel_fijo = $("#cony_tel_fijo").val();
        var cony_tel_celular = $("#cony_tel_celular").val();
        var cony_lugar_trabajo = $("#cony_lugar_trabajo").val();
        var cony_domicilio_trabajo = $("#cony_domicilio_trabajo").val();
        var cony_tel_trabajo = $("#cony_tel_trabajo").val();
        var cony_extension = $("#cony_extension").val();
        var cony_si = $("#der_cony_si").val();
        var cony_religion = $("#cony_religion").val();

        // alert(folio+" "+cendi+" "+kid_apellido_pat+" "+kid_apellido_mat+" "+kid_nombres+" "+kid_birthday+" "+kid_age+" "+kid_CURP+" "+kid_foto+" "+kid_dos_padres+" "+kid_cita+" "+kid_entrevista+" "+kid_grupo);
        $.ajax ({
            method:"POST", //similar al atributo 'method' de la etiqueta FORM
            url:"../php/form-base.php", //similar al atributo 'action' de la etiqueta FORM
            data:{folio:folio,
            cendi:cendi,
            kid_img:kid_img,
            kid_apellido_pat:kid_apellido_pat,
            kid_apellido_mat:kid_apellido_mat,
            kid_nombres:kid_nombres,
            kid_birthday:kid_birthday,
            kid_age:kid_age,
            kid_CURP:kid_CURP,
            kid_dos_padres:kid_dos_padres,
            kid_cita:kid_cita,
            kid_entrevista:kid_entrevista,
            kid_grupo:kid_grupo,
            resp_img:resp_img,//
            //
            der_img:der_img,
            der_apellido_pat:der_apellido_pat,
            der_apellido_mat:der_apellido_mat,
            der_nombres:der_nombres,
            der_cp:der_cp,
            der_entidad:der_entidad,
            der_alcaldia:der_alcaldia,
            der_colonia:der_colonia,
            der_calle:der_calle,
            der_numExt:der_numExt,
            der_numInt:der_numInt,
            der_tel_fijo:der_tel_fijo,
            der_tel_celular:der_tel_celular,
            der_email:der_email,
            der_CURP:der_CURP,
            der_ocupacion:der_ocupacion,
            der_plaza:der_plaza,
            der_sueldo:der_sueldo,
            der_numEmpleado:der_numEmpleado,
            der_adscripcion:der_adscripcion,
            der_jefe:der_jefe,
            der_jefe_puesto:der_jefe_puesto,
            der_horario:der_horario,
            der_extension:der_extension,//
                //
            cony_img:cony_img,
            cony_apellido_pat:cony_apellido_pat,
            cony_apellido_mat:cony_apellido_mat,
            cony_nombres:cony_nombres,
            cony_cp:cony_cp,
            cony_entidad:cony_entidad,
            cony_alcaldia:cony_alcaldia,
            cony_colonia:cony_colonia,
            cony_calle:cony_calle,
            cony_numExt:cony_numExt,
            cony_numInt:cony_numInt,
            cony_tel_fijo:cony_tel_fijo,
            cony_tel_celular:cony_tel_celular,
            cony_lugar_trabajo:cony_lugar_trabajo,
            cony_domicilio_trabajo:cony_domicilio_trabajo,
            cony_tel_trabajo:cony_tel_trabajo,
            cony_extension:cony_extension,
            cony_si:cony_si,
            cony_religion:cony_religion
        },
            cache:false, //evitamos que la página del servidor se almacene en la cache del navegador
            success:function(r){ //cuando el servidor de la respuesta ¿qué haremos con ella?
                if(r==1){
                    //alert("agregado con exito");
                    var url="./Reporte.php?folio="+folio+"";
                    open(url);
                    alert("Se ha enviado un correo electrónico a la dirección que registrate el cual contiene el PDF del registro");
                }else{
                    alert("Fallo el server");
                }
            }

        });
        
    });
});