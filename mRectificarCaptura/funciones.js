function llenar_tabla() {
    var tipo = $("#tipo").val();
    var sucursal = $("#cmbSucursal").val();
    var area = $("#cmbArea").val();
    var fecha = $('#fecha').val();
    $.ajax({
        url: "tabla_lista_mapeos.php",
        type: "POST",
        dateType: "html",
        data: {
            'tipo': tipo,
            'sucursal': sucursal,
            'area': area,
            'fecha': fecha
        },
        success: function(respuesta) {
            $('#contenedor_tabla').html(respuesta);
            //tabla_inicio();

        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function llenar_tabla2() {

    var tipo = $("#tipo").val();
    var sucursal = $("#cmbSucursal").val();
    var area = $("#cmbArea").val();
    var fecha = $('#fecha').val();
    var Nombre = $('#txtNombre').val();
    var data = {
        tipo: tipo,
        sucursal: sucursal,
        area: area,
        fecha: fecha
    };
    var url = "../mNuevoMapeo/tabla_detalle_mapeo.php";


    $('#table_mapeos').dataTable().fnDestroy();
    $('#table_mapeos').DataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "ajax": {
            "url": 'prueba_error500.php',
            "type": "get",
            "datatype": "json"
        },
        "columns": [
            { "data": "Nombre", "autoWidth": true },
            {
                "data": "Id", "width": "50px", "render": function (data) {
                    return '<a onclick="EliminarTipoGestion(' + data + ')" class="btn btn-danger">Eliminar</a>';
                }
            },
        ]
    })
}

function auditar(id_mapeo) {
    $.ajax({
        url: "auditar.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_mapeo': id_mapeo
        },
        success: function(respuesta) {
            alertify.success("Marcado");

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

function guarda_header() {

      $.ajax({
        url: "edit_header.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatosMapeo').serialize(),
        success: function(respuesta) {
          alertify.success('Guardado');
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
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
}

function editar(id_detalle, codigo, descripcion, n) {
    $('#cantidad_' + n).removeAttr('readonly');
    $('#cantidad_' + n).removeAttr('disabled');
}

function buscar(id_mapeo, zona, mueble, cara, area, fecha, sucursal) {
    //var fecha = $('#fecha_conteo_i1').val();
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
            $('#id').val(id_mapeo);
            $('#cmbArea').val(area);
            $('#fecha').val(fecha);
            $('#cmbSucursal').val(sucursal);
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

function elimnar_captura(id) {
    $.ajax({
        url: "elimnar_captura.php",
        type: "POST",
        dateType: "html",
        data: {
            'id': id
            
        },
        success: function(respuesta) {
            alert("Eliminado");

        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}





