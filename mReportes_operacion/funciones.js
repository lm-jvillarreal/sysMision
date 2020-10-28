function consulta_faltantes() {
    $.ajax({
        url: "tabla_cortes.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatos').serialize(),
        success: function(respuesta) {
            $('#contenedor_tabla').html(respuesta);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function subir_excel(id, input) {
    var parametros = new FormData($("#" + id)[0]);
    $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: 'importar.php', //archivo que recibe la peticion
        type: 'post', //método de envio
        contentType: false,
        processData: false,
        success: function(response) {
            var array = eval(response);
            $('#' + input).val(array);
            var jObject = array.toString();
        }

    });
}

function ventas_restaurant() {
    $.ajax({
        data: $('#frmDatosVentas').serialize(), //datos que se envian a traves de ajax
        url: 'reportes/ventas_restaurant.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
            $('#contenedor_tabla').html(response);
        }
    });
}