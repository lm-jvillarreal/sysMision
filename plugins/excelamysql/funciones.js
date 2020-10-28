function blanco() {
    $('#contenedor_tabla').load('mapeos_admin.php');
    $('#contenedor_tabla_extras').empty();
    $('#alta').hide();
    $('#modal_fecha_captura').modal('show');
    $('#excel').show();
    $('#alta_masiva').hide();
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
            $('#excel').hide();
            $('#contenedor_tabla').html(respuesta);
            $('#alta').show();
            $('#seleccion').hide();
            $('#zona').val(zona);
            $('#mueble').val(mueble);
            $('#cara').val(cara);
            $('#id_mapeo').val(id_mapeo);
            $('#fecha_conteo_i').val(fecha);

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

function guardar(id_mapeo) {
    $.ajax({
        url: "guardar_captura.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_mapeo': id_mapeo
        },
        success: function(respuesta) {
            alert("Cantidades guardadas");
            $('#contenedor_tabla').load('mapeos_admin.php');
            $('#alta').hide();
            $('#seleccion').show();
            $('#cara').val("");
            $('#zona').val("");
            $('#mueble').val("");
            $('#fecha').val("");
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function editar(id_detalle, codigo, descripcion, n) {
    $('#cantidad_' + n).removeAttr('disabled');

}

function cambiar_cantidades() {

    var id_detalle = $('#id_detalle1').val();
    var cantidad = $('#cantidad1').val();
    var n = $('#n1').val();

    $.ajax({
        url: "editar_cantidades.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_detalle': id_detalle,
            'cantidad': cantidad
        },
        success: function(respuesta) {
            alert(respuesta);
            $('#cantidad_' + n).val(cantidad);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function agregar() {
    $('#agregar_p').modal('show');
    var id_mapeo = $('#id_mapeo').val()
    $('#id_mapeoModal').val(id_mapeo);
    // var cara = $('#cara').val();
    // var mueble = $('#mueble').val();
    // var zona = $('#zona').val();
    // var fecha = $('#fecha').val();

    // $.ajax({
    //     url: "rescue.php",
    //     type: "POST",
    //     dateType: "html",
    //     data: {
    //         'cara': cara,
    //         'mueble': mueble,
    //         'zona': zona,
    //         'fecha': fecha

    //     },
    //     success: function(respuesta) {
            
    //         $('#agregar_p').modal('show');
    //         $('#id_mapeo_index').val(respuesta);

    //     },
    //     error: function(xhr, status) {

    //     },

    // });
}

function consulta(codigo) {
    $.ajax({
        url: "consulta_codigo.php",
        type: "POST",
        dateType: "html",
        data: {
            'codigo': codigo
        },
        success: function(respuesta) {
            $('#descripcionM').val(respuesta);
            $('#descripcion_captura').val(respuesta);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function filtrar_sucursal(id_sucursal, zona, mueble) {
    $.ajax({
        url: "mapeos_admin_filtrado.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_sucursal': id_sucursal,
            'zona': zona,
            'mueble': mueble
        },
        success: function(respuesta) {
            $('#contenedor_tabla').html(respuesta);
            // $('#descripcionM').val(respuesta);
            // $('#descripcion_captura').val(respuesta);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function ex_ed() {
    $.ajax({
        url: "editar_cantidades_excel.php",
        type: "POST",
        dateType: "html",
        data: $('#formulario_editar_excel').serialize(),
        success: function(respuesta) {
            cargar();
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function insert() {

    var cantidad = $('#cantidadM').val();
    var id_mapeo = $('#id_mapeo').val();
    var codigo = $('#codigoM').val();
    $.ajax({
        url: "captura_cantidades.php",
        type: "POST",
        dateType: "html",
        data: {
            'codigo': codigo,
            'cantidad': cantidad,
            'id_mapeo': id_mapeo,

        },
        success: function(respuesta) {
            reload_extras(id_mapeo);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function insert_fecha(fecha) {

    var cantidad = $('#cantidadM').val();
    var id_mapeo = $('#id_mapeo').val();
    var codigo = $('#codigoM').val();
    $.ajax({
        url: "captura_cantidades.php",
        type: "POST",
        dateType: "html",
        data: $('#frmFecha').serialize(),
        success: function(respuesta) {
            $('#fecha_conteo_i1').val(fecha)
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function insert_extra(id_mapeo) {

    $.ajax({
        url: "captura_cantidades_extras.php",
        type: "POST",
        dateType: "html",
        data: $('#frmArticulo_extra').serialize(),
        success: function(respuesta) {
            reload_extras(id_mapeo);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function editar_extras(id_captura, codigo, descripcion, id_mapeo) {
    $('#id_captura').val(id_captura);
    $('#codigo_te').val(codigo);
    $('#descripcion_te').val(descripcion);
    $('#id_mapeo_te').val(id_mapeo);
    $('#modificar_cantidad_extras').modal('show');
}

function cambiar_cantidades_extras() {
    var id_mapeo = $('#id_mapeo_te').val();
    var id_captura = $('#id_captura').val();
    var cantidad = $('#cantidad_te').val();

    $.ajax({
        url: "editar_cantidades_extras.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_captura': id_captura,
            'cantidad': cantidad
        },
        success: function(respuesta) {
            reload_extras(id_mapeo);

        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function reload_extras(id_mapeo) {
    $.ajax({
        url: "tabla_captura.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_mapeo': id_mapeo

        },
        success: function(response) {
            $('#contenedor_tabla').html(response);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function eliminar_extras(id_captura, id_mapeo) {
    $.ajax({
        url: "eliminar_extras.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_captura': id_captura

        },
        success: function(response) {
            reload_extras(id_mapeo);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function eliminar(id) {
    $.ajax({
        url: "eliminar_art.php",
        type: "POST",
        dateType: "html",
        data: {
            'id': id

        },
        success: function(response) {
            cargar();
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function cap() {
    $('#alta').hide();
    $('#alta_masiva').show();
    $('#modal_mapeo').modal('show');
    $('#seleccion').hide();
    $('#contenedor_tabla').empty();

}

function subir_excel() {
    var parametros = new FormData($("#importa")[0]);

    $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: 'importar.php', //archivo que recibe la peticion
        type: 'post', //método de envio
        contentType: false,
        processData: false,
        beforesend: function() {

        },
        success: function(response) {
            alert(response);
            //cargar();

        }
    });
}

function cargar() {
    $.ajax({
        data: {}, //datos que se envian a traves de ajax
        url: 'tabla_excel.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
            $('#contenedor_tabla').html(response);
        }
    });
}

function sucursal() {

    $.ajax({
        data: $('#formulario_map').serialize(), //datos que se envian a traves de ajax
        url: 'sucursal.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {}
    });
}

function edit(id, codigo, descripcion, cantidad) {

    $('#modificar_cantidad_excel').modal('show');
    $('#id_captura_excel').val(id);
    $('#codigo_captura').val(codigo);
    $('#descripcion_captura').val(descripcion);
    $('#cantidad_excel').val(cantidad);
}

function cancelar() {
    $('#alta_masiva').hide();
    $('#alta').show();
}