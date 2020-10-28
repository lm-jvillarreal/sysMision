function inicio(codigo, id_mapeo, estante, consecutivo) {
    $.ajax({
        url: "insertar_codigo.php",
        type: "POST",
        dateType: "html",
        data: {
            'codigo': codigo,
            'id_mapeo': id_mapeo,
            'estante': estante,
            'consecutivo': consecutivo
        },
        success: function(respuesta) {
            if (respuesta == "false") {
                $('#audio').get(0).play();
                $('#des').val("");
                alert("Este producto no existe");
                $('#codigo').val("");

            } else {
                $('#des').val(respuesta);
                //ajuste();
                //$('#contenedor_tabla').load('tabla_mapeo.php');
                r();
                $('#codigo').val("");
                var cons = parseInt(consecutivo) + 1;
                $('#consecutivo').val(cons);
            }
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}







