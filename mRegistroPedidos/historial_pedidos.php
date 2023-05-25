<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
</head>

<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <?php include '../header.php'; ?>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <?php include 'menuV2.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Pedidos | Pedidos a surtir</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_entrega">*Fecha inicial</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicial" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha_inicial" name="fecha_inicial">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_entrega">*Fecha final</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_final" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha_final" name="fecha_final">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button id="btnFiltrar" class="btn btn-danger">Filtrar datos</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_pedidos" class="table table-striped table-bordered" cellspacing="0" width="100%" style='font-size:small;'>
                    <thead>
                      <th width='5%'>#</th>
                      <th>Cliente</th>
                      <th width='9%'>Tel.</th>
                      <th>Dirección</th>
                      <th width='8%'>Pago</th>
                      <th width='5%'></th>
                      <th width='15%'></th>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <?php include 'modal_historial.php'; ?>
    <?php include 'modal_ticket.php'; ?>
    <!-- /.content-wrapper -->
    <?php include '../footer2.php'; ?>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <?php include '../footer.php'; ?>
  <!-- Page script -->
  <script>
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
    $(document).ready(function() {
      tabla_pedidos();
    });
    $('#metodo_pago').select2({
      width: '100%',
      dropdownParent: $("#modal-ticket"),
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
    });
    $('#modal-historial').on('show.bs.modal', function(e) {
      var folio = $(e.relatedTarget).data().folio;
      $("#folio").val(folio);
      tabla_pedido();
    });
    $('#modal-ticket').on('show.bs.modal', function(e) {
      var folio = $(e.relatedTarget).data().folio;
      $("#folioPedido").val(folio);
      $("#folio_ticket").val("");
      $("#folio_ticket").focus();
      $("#total_ticket").val("");
      $("#cantidad_boletos").val("");
    });

    function tabla_pedidos() {
      var fecha_inicial = $("#fecha_inicial").val();
      var fecha_final = $("#fecha_final").val();
      $('#lista_pedidos').dataTable().fnDestroy();
      $('#lista_pedidos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "order": [
          [0, "asc"]
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_historial.php",
          "dataSrc": "",
          "data": {
            fecha_inicial: fecha_inicial,
            fecha_final: fecha_final
          },
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "cliente"
          },
          {
            "data": "telefono"
          },
          {
            "data": "direccion"
          },
          {
            "data": "tipo_pedido"
          },
          {
            "data": "estatus"
          },
          {
            "data": "opciones"
          }
        ]
      });
    };

    function tabla_pedido() {
      var folio_pedido = $("#folio").val();
      $('#lista_detalleResumen').dataTable().fnDestroy();
      $('#lista_detalleResumen').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "ajax": {
          "type": "POST",
          "url": "tabla_pedido.php",
          "dataSrc": "",
          "data": {
            folio_pedido: folio_pedido
          },
        },
        "columns": [{
            "data": "cantidad"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "opciones"
          }
        ]
      });
    };
    $("#descripcion_modal").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        if ($("#folio").val() == "" || $("#modal_cantidad").val() == "" || $("#descripcion_modal").val() == "") {

        } else {
          agregar();
          $("#cantidad").val("");
          $("#descripcion").val("");
          $("#cantidad").focus();
        }
      }
    });

    $("#folio_ticket").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_ticket.php"; // El script a dónde se realizará la petición.
        var folio = $("#folio_ticket").val();
        var prefijo = folio.substr(0, 8);
        var consecutivo = folio.substr(8);
        $.ajax({
          type: "POST",
          url: url,
          data: {
            prefijo: prefijo,
            consecutivo: consecutivo,
            folio: folio,
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "no_existe") {
              swal("Verifica!", "El folio de ticket que intentas ingresar no fue encontrado en el sistema.", "error");
              $("#folio_ticket").val("");
              $("#folio_ticket").focus();
              $("#total_ticket").val("");
              $("#cantidad_boletos").val("");
            } else {
              var array = eval(respuesta);
              $("#total_ticket").val(array[0]);
              $("#cantidad_boletos").val(array[1]);
            }
          }
        });
        return false;
      }
    });

    function agregar() {
      var pedido = $("#folio").val();
      if (pedido == "") {
        alertify.error("No hay un pedido iniciado");
      } else {
        var cantidad = $("#modal_cantidad").val();
        var articulo = $("#descripcion_modal").val();
        var url = 'insertar_renglon.php';
        $.ajax({
          type: "POST",
          url: url,
          data: {
            pedido: pedido,
            articulo: articulo,
            cantidad: cantidad
          },
          success: function(respuesta) {
            alertify.success("Artículo agregado correctamente");
            tabla_pedido();
            $("#modal_cantidad").val("");
            $("#descripcion_modal").val("");
            $("#modal_cantidad").focus();
          }
        });
      }
      return false;
    }

    function eliminar_renglon(id) {
      var url = 'eliminar_renglon.php';
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id,
        },
        success: function(respuesta) {
          tabla_pedido();
          totales();
        }
      });
      return false;
    }

    function finalizar() {
      var url = 'finaliza_pedido.php';
      var folio_ticket = $("#folio_ticket").val();
      var prefijo = folio_ticket.substr(0, 8);
      var consecutivo = folio_ticket.substr(8);
      var id_pedido = $("#folioPedido").val();
      var total_ticket = $("#total_ticket").val();
      var metodo_pago = $("#metodo_pago").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio_ticket: folio_ticket,
          prefijo: prefijo,
          consecutivo: consecutivo,
          id_pedido: id_pedido,
          total_ticket: total_ticket,
          metodo_pago: metodo_pago
        },
        success: function(respuesta) {
          if (respuesta == "vacio") {
            alertify.error("Debes ingresar un número de operación");
          } else if (respuesta == "no_existe") {
            alertify.error("El número de operación no fue encontrado en el sistema");
          } else if (respuesta == "ok") {
            alertify.success("El pedido ha sido finalizado correctamente");
            tabla_pedidos();
            $('#modal-ticket').modal('toggle');
            var tab = window.open('ticket_pdf.php?flp=' + id_pedido, '_blank');
            if (tab) {
              tab.focus(); //ir a la pestaña
            } else {
              alertify.error('Pestañas bloqueadas, activa las ventanas emergentes (Popups)');
            }
          }
        }
      });
    }
    $("#btnFinaliza").click(function() {
      finalizar();
    });
    $("#btnFiltrar").click(function() {
      tabla_pedidos();
    });

    function ver_pdf(pedido) {
      var url = 'validar_surtidor.php';
      $.ajax({
        type: "POST",
        url: url,
        data: {
          pedido: pedido,
        },
        success: function(respuesta) {
          if (respuesta == "NO") {
            var url = "insertar_surtidor.php";
            swal("Ingresar surtidor", {
                content: {
                  element: "input",
                  attributes: {
                    placeholder: "nombre del surtidor",
                    type: "text",
                  },
                },
              })
              .then((value) => {
                var surtidor = value;
                $.ajax({
                  type: "POST",
                  url: url,
                  data: {
                    surtidor: surtidor,
                    pedido: pedido
                  },
                  success: function(respuesta) {
                    if (respuesta == "vacio") {

                    } else {
                      var tab = window.open('pedido_pdf.php?flp=' + pedido, '_blank');
                      if (tab) {
                        tab.focus(); //ir a la pestaña
                      } else {
                        alertify.error('Pestañas bloqueadas, activa las ventanas emergentes (Popups)');
                      }
                    }
                  }
                });
              });
          } else {
            var tab = window.open('pedido_pdf.php?flp=' + pedido, '_blank');
            if (tab) {
              tab.focus(); //ir a la pestaña
            } else {
              alertify.error('Pestañas bloqueadas, activa las ventanas emergentes (Popups)');
            }
          }
        }
      });
      return false;
    }
  </script>
</body>

</html>