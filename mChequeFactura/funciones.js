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