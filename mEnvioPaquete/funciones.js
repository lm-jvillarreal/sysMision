function GenerarPdf(folio,valor)
    {
        cadena="pdf/pdfListaPedido.php?folio="+folio;
        window.open(cadena, '_blank');
    }
function GenerarPdf2(folio,valor)
    {
        cadena="pdf/pdfListaPedido2.php?folio="+folio;
        window.open(cadena, '_blank');
    }
function Generarliberacion(folio)
    {
        location.href ="editar.php?folio="+folio;
    }
function liberar(folio) {
    $.ajax({
        url:"liberar.php",
        data:{'folio':folio},
        type:"POST",
        dateType:"html",
        success:function(respuesta)
        {
            llenar();
            alertify.success("Se libero correctamente el pedido");
        },
        error:function(xhr,status){
            alert("no se muestra");
        }
    });
}

function llenar()
{
    $.ajax({
        url:"tabla.php",
        type:"POST",
        dateType:"html",
        success:function(respuesta)
        {
            $("#llenar").html(respuesta);
        },
        error:function(xhr,status){
            alert("no se muestra");
        }
    });
}
function eliminar(folio)
{
    $.ajax({
        url:"eliminar.php",
        type:"POST",
        dateType:"html",
        data:{'folio':folio},
        success:function(respuesta)
        {
            if(respuesta == "ok"){
                alertify.success("Se ha Eliminado Correctamente");
                llenar();
            }
            else{
                alertify.error("Ha Ocurrido un Error");   
            }
        }
    });
}

function llenar2()
{
    $.ajax({
        url:"tabla2.php",
        type:"POST",
        dateType:"html",
        success:function(respuesta)
        {
            $("#llenar2").html(respuesta);
        },
        error:function(xhr,status){
            alert("no se muestra");
        }
    });
}

function llenar3()
{
    $.ajax({
        url:"tabla3.php",
        type:"POST",
        dateType:"html",
        success:function(respuesta)
        {
            $("#llenar3").html(respuesta);
        },
        error:function(xhr,status){
            alert("no se muestra");
        }
    });
}