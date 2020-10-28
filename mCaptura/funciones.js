function guardar_ca(id_mapeo) {
    var fecha_conteo = $('#fecha_conteo_i1').val();
    
        $.ajax({
            url: "guardar_captura.php",
            type: "POST",
            dateType: "html",
            data: {
                'id_mapeo': id_mapeo,
                'fecha_conteo': fecha_conteo
            },
            success: function(respuesta) {

                alert("Cantidades guardadas");
                location.reload();
                // $('#contenedor_tabla').load('mapeos_admin.php');
                // $('#alta').hide();
                // $('#seleccion').show();
                // $('#cara').val("");
                // $('#zona').val("");
                // $('#mueble').val("");
                // $('#fecha').val("");
            },
            error: function(xhr, status) {
                alert(xhr);
            },
        });
    
    
}

function capturar(id_mapeo, id_detalle, codigo, cantidad, n) {
    $.ajax({
        url: "captura_cantidades.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_mapeo': id_mapeo,
            'codigo': codigo,
            'cantidad': cantidad,
            'id_detalle': id_detalle
        },
        success: function(respuesta) {
            var sig = parseInt(n) + 1;
            $("#cantidad_" + n).prop('disabled', true);
            $('#cantidad_' + sig).focus();
            $('#cantidad_' + sig).val("");

        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function guardar_captura(){
    alert("Captura Guardada");
    location.reload();
}

function capturar_dos(id_mapeo, id_detalle, codigo, cantidad, n) {
    $.ajax({
        url: "captura_cantidades.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_mapeo': id_mapeo,
            'codigo': codigo,
            'cantidad': cantidad,
            'id_detalle': id_detalle
        },
        success: function(respuesta) {
            var sig = parseInt(n) + 1;
            $("#cantidad_" + n).prop('disabled', true);
            $('#cantidad_' + sig).focus();
            $('#cantidad_' + sig).val("");

        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function mostrar_lista() {
    $('#contenedor_tabla_detalle').hide();
    $('#contenedor_tabla').show();
    $('#fecha_conteo_i1').removeAttr('readonly');
}

function editar(id_detalle, codigo, descripcion, n) {
    $('#cantidad_' + n).removeAttr('readonly');
    $('#cantidad_' + n).removeAttr('disabled');
}

function buscar(id_mapeo, zona, mueble, cara) {
    var fecha = $('#fecha_conteo_i1').val();
    // if (!fecha) {
    //     Swal.fire({
    //           type: 'error',
    //           title: 'Oops...',
    //           text: 'Favor de seleccionar una fecha válida de captura',
    //           footer: ''
    //         });
    // }else{
        $.ajax({
            url: "tabla_captura.php",
            type: "POST",
            dateType: "html",
            data: {
                'id_mapeo': id_mapeo,
                'fecha': fecha
            },
            success: function(respuesta) {
                // $('#excel').hide();
                $('#contenedor_tabla_detalle').html(respuesta);
                $('#contenedor_tabla_detalle').removeAttr('style');
                $('#contenedor_tabla').hide();
                $('#fecha_conteo_i1').attr('readonly', 'true');
                            // $('#alta').show();
                // $('#seleccion').hide();
                $('#txtZona').val(zona);
                $('#txtMueble').val(mueble);
                $('#txtCara').val(cara);
                $('#id_mapeo').val(id_mapeo);
                // $('#fecha_conteo_i').val(fecha);

            },
            error: function(xhr, status) {
                alert(xhr);
            },
        });    
    //}

    
}

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







