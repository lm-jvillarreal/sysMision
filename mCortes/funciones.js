function bitacora(id_usuario, id_reporte) {
    $.ajax({
        data: {
            'id_usuario': id_usuario,
            'id_reporte': id_reporte
        }, //datos que se envian a traves de ajax
        url: '../../reportes_infofin/mReportes/agregar_bitacora.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
        }
    });
}

function insertar_registro(id_persona, id_manual) {
    alert(id_persona);
    alert(id_manual);
    $.ajax({
        url: "usuarios_manuales.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_persona': id_persona,
            'id_manual': id_manual
        },
        success: function(respuesta) {
            alert(respuesta);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function consulta() {
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

function insertar_orden_s() {
    var parametros = new FormData($("#frm_s_orden")[0]);
    $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: 'insertar_orden_s.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        contentType: false,
        processData: false,
        success: function(response) {
            alert(response);
        }
    });
}