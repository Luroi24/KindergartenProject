const regExFol = /(?:P[PE]|\d\d)\d\d\d\d\d\d\d\d/i;

$(document).ready(function(){
    $("#recuperaF_form").submit(function(e){
        e.preventDefault();
        var folio = $("#folio").val();
        var errors;
        if(folio.length < 10 || !regExFol.test(folio)){
            // folio.classList.add("is-invalid");
            $("#mensaje").html("Debe de tener 10 dígitos. Puede comenzar por 'PE' o 'PP'");
            errors++;
        }else{
            $.ajax ({
                method:"POST", //similar al atributo 'method' de la etiqueta FORM
                data:{folio:folio},
                cache:false, //evitamos que la página del servidor se almacene en la cache del navegador
                success:function(respAX){ //cuando el servidor de la respuesta ¿qué haremos con ella?
                    if(respAX==''){  // No existe el folio
                        $("#mensaje").html("No existe el folio. Inténtalo de nuevo o regístrate dando clic <a href='../formulario.html'>aquí</a>");
                    }else{ // Existe el folio
                        var url = "../Reporte.php?folio="+folio;
                        window.open(url);
                    }
                }
    
            });
        }
    });
});