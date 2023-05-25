<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$hora = date("h:i:s");
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <script src="funciones.js?v=<?php echo (rand()); ?>"></script>
</head>

<body class="hold-transition skin-red sidebar-mini" onload="javascript:cargar_tabla()">
  <div class="wrapper">
    <header class="main-header">
      <?php include '../header.php'; ?>
    </header>
    <aside class="main-sidebar">
      <?php include 'menuV.php'; ?>
    </aside>
    <div class="content-wrapper">
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Compras | Entradas vs Facturas</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="frmDatosAjustes">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label>*Sucursal</label>
                    <select name="sucursal" class="form-control" id="suc">
                      <option value="" disabled selected>Seleccione...</option>
                      <option value="1">Diaz Ordaz</option>
                      <option value="2">Arboledas</option>
                      <option value="3">Villegas</option>
                      <option value="4">Allende</option>
                      <option value="5">La Petaca</option>
                      <option value="6">Montemorelos</option>
                      <option value="99">CEDIS</option>
                      <option value="203">CEDIS Ropa</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label for="descripcion">*Movimiento</label>
                    <select name="movimiento" class="form-control" id="movimiento">
                      <option disabled selected>Seleccione...</option>
                      <option value="ENTSOC">Entrada sin orden de compra</option>
                      <option value="ENTCOC">Entrada con orden de compra</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label for="bodega">*Folio</label>
                    <input class="form-control" type="text" name="folio" id="folio_mov" onkeyup="if(event.keyCode == 13)execute();">
                  </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="bodega">Proveedor</label>
                    <input type="text" name="proveedor" id="proveedor" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="bodega">Total</label>
                    <input type="text" name="txtTotal" id="txtTotal" class="form-control" readonly>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tipo_operacion">Operación</label>
                    <select name="tipo_operacion" id="tipo_operacion" class="form-control">
                      <option value=""></option>
                      <option value="CARGO">CARGO</option>
                      <option value="ABONO">ABONO</option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box box-footer text-right">
            <a href="#" onclick="registrar_tabla()" class="btn btn-danger">Registrar</a>
            <button onclick="cons()" class="btn btn-danger">Consultar</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Información</h3>
          </div>
          <div class="box-body">
            <form id="frmTabla" name="frmTabla">
              <div id="contenedor_tabla"></div>
            </form>

          </div>
        </div>
      </section>
    </div>
    <?php include '../footer2.php'; ?>
    <div class="control-sidebar-bg"></div>
  </div>
  
  <?php include '../footer.php';?>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>


  <!-- <script>CargarBodega();</script>
<script>CargarSistema();</script> -->
  <script>
    function execute() {
      mostrar_tabla();
      consulta_proveedor();
    }

    function estilo_tablas() {
      $('#lista').DataTable({
        'paging': false,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': true,
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        }
      })
    }
    $('.form_date').datetimepicker({
      language: 'es',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });

    function cons() {
      var folio = $('#folio_mov').val();
      var movimiento = $('#movimiento').val();
      var sucursal = $('#suc').val();
      $.ajax({
        url: "consulta_entrada_existe.php",
        type: "POST",
        dateType: "html",
        data: {
          'folio': folio,
          'movimiento': movimiento,
          'sucursal': sucursal
        },
        success: function(respuesta) {
          if (respuesta == "true") {
            mostrar_tabla();
            consulta_proveedor();
            //registrar_tabla();
            //consultar();
          } else {
            alert("Ya existe un registro con esos datos");
            //mostrar_tabla(); 
            //consulta_proveedor();
          }
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function consultar() {
      $.ajax({
        url: "consulta_entrada.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatosAjustes').serialize(),
        success: function(respuesta) {
          consultar_detalle();
          var array = eval(respuesta);
          if (array[5] == null) {
            var factura = array[6];
          } else {
            var factura = array[5];
          }
          $('#folio').val(array[0]);
          $('#sucursal').val(array[7]);
          $('#proveedor').val(array[3]);
          $('#tipo_mov').val(array[1]);
          $('#factura').val(factura);
          $('#modal_datos').modal('show');
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function consultar_detalle() {
      $.ajax({
        url: "consulta_detalle_entrada.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatosAjustes').serialize(),
        success: function(respuesta) {
          var array_detalle = eval(respuesta);
          $('#ieps').val(array_detalle[3]);
          $('#iva').val(array_detalle[2]);
          $('#subtotal').val(array_detalle[1]);
          $('#total_entrada').val(array_detalle[0]);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function insertar() {
      $.ajax({
        url: "insertar_registro.php",
        type: "POST",
        dateType: "html",
        data: $('#formulario').serialize(),
        success: function(respuesta) {

          var array = eval(respuesta);
          $('#dif').val(array[1]);
          $('#id_nota').val(array[0]);
          $('#id_nota2').val(array[0]);
          mostrar_tabla(array[0]);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function mostrar_tabla() {
      var folio = $('#folio_mov').val();
      var movimiento = $('#movimiento').val();
      var sucursal = $('#suc').val();
      let data = {
        folio: folio,
        movimiento: movimiento,
        sucursal: sucursal
      };
      var id = $('#folio_mov').val();
      $.ajax({
        url: "tabla_captura_new.php",
        type: "POST",
        dateType: "html",
        data: data,
        success: function(response) {
          $('#contenedor_tabla').html(response);
        },
        error: function(xhr, status) {

        },
      });
    }

    function consulta_proveedor() {
      var folio = $('#folio_mov').val();
      var movimiento = $('#movimiento').val();
      var sucursal = $('#suc').val();
      let data = {
        folio: folio,
        movimiento: movimiento,
        sucursal: sucursal
      };
      $.ajax({
        url: "consulta_proveedor.php",
        type: "POST",
        dateType: "html",
        data: data,
        success: function(response) {
          $('#proveedor').val(response);
        },
        error: function(xhr, status) {

        },
      });
    }

    function mostrar_tabla_notas(id_sucursal) {
      $.ajax({
        url: "tabla_notas_diferencia.php",
        type: "POST",
        dateType: "html",
        data: {
          'id_sucursal': id_sucursal
        },
        success: function(respuesta) {
          $('#contenedor_tabla').html(respuesta);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function calcular(cantidad, diferencia, n) {
      var impuesto = $('#cmbImpuesto_' + n).val();
      $('#clave_' + n).val(impuesto);

      var f_cantidad = parseFloat(cantidad);
      var f_diferencia = parseFloat(diferencia);

      var calculo = f_cantidad * f_diferencia;
      console.log(calculo);
      $('#total_bruto_' + n).val(calculo);
      if (impuesto != 0) {
        var f_impuesto = parseFloat(impuesto);
        var f_calculo = parseFloat(calculo);
        calculo = f_impuesto * f_calculo;
        console.log(impuesto);
      } else {
        calculo = calculo;

      }

      $('#total_' + n).text(calculo);
      $('#totali_' + n).val(calculo);

      calcular_total();

    }

    function calcular_total() {
      let total = 0;
      $("#capture > tbody > tr").each(function() {

        var t = $(this).find('td').eq(5).html();
        total = parseFloat(total) + parseFloat(t);
        var a = {
          t: parseFloat(t),
          tot: parseFloat(total)
        };
        $('#txtTotal').val(a.tot);
      });
    }

    function validar() {
      var folio = $('#folio_mov').val();
      var tipo_mov = $('#movimiento').val();
      var sucursal = $('#suc').val();
      var proveedor = $('#proveedor').val();
      $.ajax({
        url: "consulta_existe.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatosAjustes').serialize(),
        success: function(respuesta) {
          //mostrar_tabla(respuesta);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function registrar_tabla() {
      var folio = $('#folio_mov').val();
      var tipo_mov = $('#movimiento').val();
      var sucursal = $('#suc').val();
      var proveedor = $('#proveedor').val();
      var dif_total = $('#txtTotal').val();
      var tipo_operacion = $("#tipo_operacion").val();
      if (folio == "" || tipo_mov == "" || sucursal == "" || tipo_operacion == "") {
        alert("Rellenar todos los datos");
      } else {
        if (dif_total == 0 || dif_total == "") {
          alert("El total no puede ser 0");
        } else {
          var form_data = new FormData(document.forms.namedItem("frmTabla"));
          form_data.append("folio", folio);
          form_data.append("tipo_mov", tipo_mov);
          form_data.append("sucursal", sucursal);
          form_data.append("proveedor", proveedor);
          form_data.append("diferencia_total", dif_total);
          form_data.append("tipo_operacion", tipo_operacion);
          fetch('registrar.php', {
            method: 'POST',
            body: form_data
          }).then(function(respuesta) {
            return respuesta.text().then(function(text) {
              console.log(text);
              //location.reload();
              window.open("nota_cargo.php?folio=" + folio + "&tipo_mov=" + tipo_mov + "&sucursal=" + sucursal);
            });
          });
        }
      }

    }

    function guardar(diferencia) {
      var id = $('#id_nota').val();
      var sucursal = $('#suc').val();
      if (diferencia > 0) {
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false,
        })

        swalWithBootstrapButtons.fire({
          title: 'Tienes una diferencia de $' + diferencia + '!',
          text: "Que deseas hacer?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Subir carta faltante',
          cancelButtonText: 'Registrar diferencias',
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            $('#modal_carta').modal('show');
            //mostrar_tabla_notas(sucursal);
          } else if (
            // Read more about handling dismissals
            result.dismiss === Swal.DismissReason.cancel
          ) {

          }
        });
      } else {
        alert("Cambios guardados");
        //location.href = "pdfEjemplo/index.php?id="+id;
        window.open("pdfEjemplo/index.php?id=" + id);
        //location.reload();
      }
    }

    function mostrar_tabla_cartas() {
      var id_sucursal = $('#suc').val();
      $.ajax({
        url: "tabla_cartas.php",
        type: "POST",
        dateType: "html",
        data: {
          'id_sucursal': id_sucursal
        },
        success: function(respuesta) {
          $('#contenedor_tabla').html(respuesta);

        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function eliminar_dif(id, sucursal) {
      $.ajax({
        url: "eliminar_dif.php",
        type: "POST",
        dateType: "html",
        data: {
          'id': id
        },
        success: function(respuesta) {
          alert("Registro borrado");
          mostrar_tabla_cartas(respuesta);

        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }
  </script>
</body>

</html>