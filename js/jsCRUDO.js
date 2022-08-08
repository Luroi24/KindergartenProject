$(document).ready(
    function(){

    $("#fol").hide();
    $("#table").hide();
    $("#sub").hide();
    $("#Error").hide();
    $("#Exito").hide();
    $("#Form2").hide();
    $("#recargar").hide();

    $( "#Tipo" ).change(function() {
        var acc= $("#Tipo").val();
        switch (acc){ 
            case 'D':
                $("#fol").show();
                $("#table").hide();
                $("#sub").hide();
            break;
            case 'U':
                $("#fol").show();
                $("#table").hide();
                $("#sub").hide();
            break;
            case 'R':
                $("#table").show();
                $("#fol").hide();
                $("#sub").hide();
            break;
            case 'C':
                $("#table").hide();
                $("#fol").hide();
                $("#sub").show();
            break;
        }
    });

    $("#table").change(function(){
        $("#sub").show();
    });

    $("#fol").change(function(){
        $("#sub").show();
    });

    /**/

    $("#accion").submit(function(e){
        e.preventDefault();
        $("#mainc").hide();
        $("#recargar").show();
        var acc= $("#Tipo").val();
        //alert(acc);
        switch (acc){ 
            case 'D':
                var fol=$("#fol").val();
                $.ajax ({method:"POST", url:"CRUDD.php", data:{fol:fol}, cache:false, success:function(res){
                    alert(res);
                    if(res==1){
                        $("#Exito").show();   
                    }else{
                        $("#Error").show();
                    }
                }});             
            break;
            case 'U':
                $("#Form2").show();
                $("#CENDI").val("1");
                //alert("Update");
                var fol=$("#fol").val();
                //d
                $.ajax ({method:"POST", url:"CRUDU.php", data:{fol:fol}, cache:false, ataType:"JSON", success:function(res){
                //alert(res);
                var data =JSON.parse(res);
                //alert(data.CP_D);
                $("#folio").val(data.FOLIO);
                $("#folio").attr("disabled","TRUE");
                $("#CENDI").val(data.CENDI);
                $("#kid_apellido_pat").val(data.APE_PAT_M);
                $("#kid_apellido_mat").val(data.APE_MAT_M);
                $("#kid_nombres").val(data.NOM_M);
                var birthday= new Date(data.FECHAN);

                $("#kid_birthday").val(data.FECHAN);
                const dateOfBirth = new Date($("#kid_birthday").val());
                const date = dateOfBirth.getTime();
                var month = dateOfBirth.getMonth();
                var currMonth = new Date().getMonth();
                const now = new Date().getTime();
                var age = Math.floor((now - date ) / (1000 * 60 * 60 * 24 * 365.25));
                //alert(age);
                $("#kid_age").val(age);
                if( currMonth >= month){
                    (document.getElementById('kid_age_months')).value = currMonth - month;
                } else{
                    (document.getElementById('kid_age_months')).value = 12 + currMonth - month;
                }
                /*$("#kid_pimg_text").hide();
                $("#kid_pimg").attr("src","img/customerImages/"+data.FOTO_M+"").css({"display": "block" });*/

                $("#kid_age").val(data.Edad);
                $("#kid_CURP").val(data.CURP);
                $("#grupo").val(data.GRUPO);
            // Datos del derechohabiente
                $("#der_apellido_pat").val(data.APE_PAT_D);
                $("#der_apellido_mat").val(data.APE_MAT_D);
                $("#der_nombres").val(data.NOM_D);
                $("#der_cp").val(data.CP_D);
                $("#der_entidad").val(data.ESTADO_D);
                $("#der_alcaldia").val(data.MUNICIPIO_D);
                $("#der_colonia").val(data.COLONIA_D);
                $("#der_calle").val(data.calle_D);
                $("#der_numExt").val(data.NUM_EXT_D);
                $("#der_numInt").val(data.NUM_INT_D);
                $("#der_tel_fijo").val(data.TELF_D);
                $("#der_tel_celular").val(data.TELC_D);
                $("#der_email").val(data.MAIL_D);
                $("#der_CURP").val(data.CURP_D);
                $("#der_ocupacion").val(data.OCUPACION);
                $("#der_plaza").val(data.PLAZA_D);
                $("#der_sueldo").val(data.SUELDO_D);
                $("#der_numEmpleado").val(data.NUMEROE_D);
                $("#der_adscripcion").val(data.ADSCRIPCION);
                $("#der_jefe").val(data.NOMJEFE);
                $("#der_jefe_puesto").val(data.CARGOJEFE_D);
                $("#der_horario").val(data.HORARIO);
                $("#der_extension").val(data.EXT_D);
                if((data.PADRES)==1){
                    $("#der_cony_si").prop("checked", true);
                }else{
                    $("#der_cony_no").prop("checked", true);
                }
            // Datos del conyuge

                $("#cony_apellido_pat").val(data.APE_PAT_C);
                $("#cony_apellido_mat").val(data.APE_MAT_C);
                $("#cony_nombres").val(data.NOM_C);
                $("#cony_cp").val(data.CP_C);
                $("#cony_entidad").val(data.ESTADO_C);
                $("#cony_alcaldia").val(data.MUNICIPIO_C);
                $("#cony_colonia").val(data.COLONIA_C);
                $("#cony_calle").val(data.CALLE_C);
                $("#cony_numExt").val(data.NUM_EXT_C);
                $("#cony_numInt").val(data.NUM_INT_C);
                $("#cony_tel_fijo").val(data.TELC_C);
                $("#cony_tel_celular").val(data.TELC_C);
                $("#cony_lugar_trabajo").val(data.LUGART_C);
                $("#cony_domicilio_trabajo").val(data.DOMT_C);
                $("#cony_tel_trabajo").val(data.TELT_C);
                $("#cony_extension").val(data.EXT_C);
                $("#cony_religion").val(data.RELIGION_C);

                

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
                    
                    $.ajax ({method:"POST", url:"CRUDD.php", data:{fol:folio}, cache:false, success:function(res){
                        console.log(res);
                        /*if(res==1){
                            $("#Exito").show();   
                        }else{
                            $("#Error").show();
                        }*/
                    }});

                    // alert(folio+" "+cendi+" "+kid_apellido_pat+" "+kid_apellido_mat+" "+kid_nombres+" "+kid_birthday+" "+kid_age+" "+kid_CURP+" "+kid_foto+" "+kid_dos_padres+" "+kid_cita+" "+kid_entrevista+" "+kid_grupo);
                    $.ajax ({
                        method:"POST", //similar al atributo 'method' de la etiqueta FORM
                        url:"./form-base/form-base.php", //similar al atributo 'action' de la etiqueta FORM
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
                            }else{
                                alert("Fallo el server");
                            }
                            location.reload();
                        }
            
                    });
                    
                });


            }});
                
            break;
            case 'R':
                var table=$("#table").val();
                $.ajax ({method:"POST", url:"CRUDR.php", data:{table:table}, cache:false, success:function(res){ $("#result").html(res)}});
                
            break;
            case 'C':
                $("#Form2").show();
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
                    
                    $.ajax ({method:"POST", url:"CRUDD.php", data:{fol:folio}, cache:false, success:function(res){
                        console.log(res);
                        /*if(res==1){
                            $("#Exito").show();   
                        }else{
                            $("#Error").show();
                        }*/
                    }});

                    // alert(folio+" "+cendi+" "+kid_apellido_pat+" "+kid_apellido_mat+" "+kid_nombres+" "+kid_birthday+" "+kid_age+" "+kid_CURP+" "+kid_foto+" "+kid_dos_padres+" "+kid_cita+" "+kid_entrevista+" "+kid_grupo);
                    $.ajax ({
                        method:"POST", //similar al atributo 'method' de la etiqueta FORM
                        url:"./form-base/form-base.php", //similar al atributo 'action' de la etiqueta FORM
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
                            }else{
                                alert("Fallo el server");
                            }
                            location.reload();
                        }
            
                    });
                    
                });
            break;
        } 
        //$.ajax ({method:"POST", url:"CRUDR.php", cache:false, success:function(res){ $("#container").html(res)}});
    });
    $("#recargar").click(function(e){
            location.reload();
    });
    /*$("#eliminar").submit(function(e){
        e.preventDefault();
        var fol = $("#fol").val();
        alert(fol);
        //$.ajax ({method:"POST", url:"CRUDD.php", data:{fol:fol}, cache:false, success:function(res){ $("#container").html(res)}});
        
    });*/

});