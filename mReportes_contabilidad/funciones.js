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