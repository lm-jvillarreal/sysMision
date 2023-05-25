function agregar_cod() {
    var id_mapeo = $('#id_mapeoCon').val();
    $('#id_mapeo_modal').val(id_mapeo);
    $('#modal_insertar').modal('show');
}

function llenar_tabla(tipo) {
    $.ajax({
        url: "tabla_lista_mapeos.php",
        type: "POST",
        dateType: "html",
        data: {
            'tipo': tipo
        },
        success: function(respuesta) {
            $('#contenedor_tabla').html(respuesta);

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

function editar_renglon(codigo, descripcion, id, consecutivo){
    $('#txtCodProd').val(codigo);
    $('#txtDescripcionM').val(descripcion);
    $('#txtIdRenglon').val(id);
    $('#txtConsecutivo').val(consecutivo);
    $('#modal_editar').modal('show');
}

function mostrar_lista() {
    $('#contenedor_tabla_detalle').hide();
    $('#contenedor_tabla').show();
}

function editar(id_detalle, codigo, descripcion, n) {
    $('#cantidad_' + n).removeAttr('readonly');
    $('#cantidad_' + n).removeAttr('disabled');
}

function buscar(id_mapeo, zona, mueble, cara) {
    var fecha = $('#fecha_conteo_i1').val();
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
            // $('#alta').show();
            // $('#seleccion').hide();
            $('#txtZona').val(zona);
            $('#txtMueble').val(mueble);
            $('#txtCara').val(cara);
            // $('#id_mapeo').val(id_mapeo);
            // $('#fecha_conteo_i').val(fecha);

        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
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

function editar(id_mapeo, zona, mueble, cara, area, sucursal) {
    $.ajax({
        url: "editar.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_mapeo': id_mapeo

        },
        success: function(respuesta) {
            //$('#inicio_cont').modal('show');
            var conse = 1;
            var esta = 1;
            $('#edicion').show();
            $('#contenedor_tabla').html(respuesta);
            $('#lista_mapeos').hide();
            $('#zonaCon').val(zona);
            $('#muebleCon').val(mueble);
            $('#caraCon').val(cara);
            $('#id_mapeoCon').val(id_mapeo);
            $('#cmbArea').val(area);
            $('#cmbSucursal').val(sucursal);
            $('#txtCodigoCon').removeAttr('readonly');
            $('#txtConsecutivoCon').removeAttr('readonly');
            $('#txtEstanteCon').removeAttr('readonly');
            alertify.success("Favor de colocar valores en estante y consecutivo");
            $('#txtEstanteCon').focus();
        },
        error: function(xhr, status) {

        },

    });
}

function cargar(id_mapeo) {
    $.ajax({
        url: "editar.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_mapeo': id_mapeo

        },
        success: function(respuesta) {
            
            $('#contenedor_tabla').html(respuesta);
            
        },
        error: function(xhr, status) {

        },

    });
}