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
            alertify.success("Codigos cargados");
        }

    });
}

function mostrar_datos() {
    var familia = $('#familia').val();
    var departamento = $('#departamento').val();
    var array = $('#array_compras_vs').val();
    var sucursal = $('#sucursal').val();
    $.ajax({
        data: {
            'familia': familia,
            'departamento': departamento,
            'array': array,
            'sucursal': sucursal
        }, //datos que se envian a traves de ajax
        url: 'tabla_existencias.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
            $('#contenedor').html(response);
        }
    });
}