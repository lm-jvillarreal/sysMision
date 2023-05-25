<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
</head>
<style>
  #modal_articulos {
    width: 80% !important;
  }
</style>

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
        <div class="row">
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Control de Pedidos | Pedidos a surtir</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table id="lista_pedidos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <th width='5%'>Folio</th>
                          <th>Cliente</th>
                          <th width='10%'>Teléfono</th>
                          <th>Dirección</th>
                          <th width='10%'>Tipo</th>
                          <th width='10%'>Asignado a</th>
                          <th width='5%'>Estatus</th>
                          <th width='5%'></th>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <div class="row">
                  <div class="col-md-6 text-left">
                    <button class="btn btn-danger" id="btn-detalle">Agregar artículos</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-9">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Control de Pedidos | Detalle del pedido</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-3">
                    <input type="text" name="folio" id="folio" class="form-control" readonly="true">
                    <input type="hidden" name="txtSubtotal" id="txtSubtotal">
                    <input type="hidden" name="txtImpuestos" id="txtImpuestos">
                    <input type="hidden" name="txtTotal" id="txtTotal">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table id="tabla_resumen" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <th width='5%'>Codigo</th>
                          <th>Descripcion</th>
                          <th width='5%'>U.M.</th>
                          <th width='5%'>Cantidad</th>
                          <th width='5%'>Surtido</th>
                          <th width='5%'></th>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Control de Pedidos | Totales</h3>
              </div>
              <div class="box-body">
                <div class="col-md-12">
                  <div class="info-box bg-aqua" style='display: none'>
                    <span class="info-box-icon"><i class="ion ion-social-usd-outline"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">SUBTOTAL</span>
                      <span class="info-box-number">
                        <div id="SUBTOTAL">$0.00</div>
                      </span>

                      <div class="progress">
                        <div class="progress-bar" id=""></div>
                      </div>
                      <span class="progress-description">
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="info-box bg-aqua" style='display: none'>
                    <span class="info-box-icon"><i class="ion ion-social-usd-outline"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">IMPUESTOS</span>
                      <span class="info-box-number">
                        <div id="IMPUESTOS">$0.00</div>
                      </span>
                      <div class="progress">
                        <div class="progress-bar" id=""></div>
                      </div>
                      <span class="progress-description">
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="ion ion-social-usd-outline"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">TOTAL</span>
                      <span class="info-box-number">
                        <div id="TOTAL">$0.00</div>
                      </span>
                      <div class="progress">
                        <div class="progress-bar" id=""></div>
                      </div>
                      <span class="progress-description">
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button class="btn btn-success" id="btn-finalizar">Finalizar Pedido</button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <?php include 'modal_detalle.php'; ?>
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
    $(document).ready(function() {
      tabla_pedidos();
    });

    function tabla_pedidos() {
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
            "data": "surtidor"
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

    function tabla_articulos() {
      var descripcion = $("#descripcion").val();
      $('#lista_articulos').dataTable().fnDestroy();
      $('#lista_articulos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "order": [
          [3, "desc"]
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_articulos.php",
          "dataSrc": "",
          "data": {
            descripcion: descripcion
          },
        },
        "columns": [{
            "data": "consecutivo"
          },
          {
            "data": "codigo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "exist"
          },
          {
            "data": "um"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "precio_venta"
          },
          {
            "data": "opciones"
          }
        ]
      });
    };

    $("#descripcion").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        if ($("#descripcion").val() == "") {

        } else {
          tabla_articulos();
        }
      }
    });

    function tabla_resumen(folio) {
      $("#folio").val(folio);
      $('#tabla_resumen').dataTable().fnDestroy();
      $('#tabla_resumen').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "ajax": {
          "type": "POST",
          "url": "tabla_modalResumen.php",
          "dataSrc": "",
          "data": {
            folio: folio
          },
        },
        "columns": [{
            "data": "codigo",
            "width": "5%"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "um",
            "width": "5%"
          },
          {
            "data": "cantidad",
            "width": "5%"
          },
          {
            "data": "surtido",
            "width": "5%"
          },
          {
            "data": "opciones",
            "width": "5%"
          }
        ]
      });
      totales();
    };
    $("#btn-detalle").click(function() {
      $("#modal-articulos").modal("show");
    });

    function agregar(articulo, consecutivo) {
      var pedido = $("#folio").val();
      if (pedido == "") {
        alertify.error("No hay un pedido iniciado");
      } else {
        var cantidad = $("#cantidad_" + consecutivo).val();
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
            tabla_resumen(pedido);
            totales();
          }
        });
      }
      return false;
    }

    function eliminar_renglon(id) {
      var folio = $("#folio").val();
      var url = 'eliminar_renglon.php';
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id,
        },
        success: function(respuesta) {
          tabla_resumen(folio);
        }
      });
      return false;
    }

    function totales() {
      var pedido = $("#folio").val();
      var url = 'totales.php';
      $.ajax({
        type: "POST",
        url: url,
        data: {
          pedido: pedido,
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#SUBTOTAL").html(array[0]);
          $("#txtSubtotal").val(array[0]);
          $("#IMPUESTOS").html(array[1]);
          $("#txtImpuestos").val(array[1]);
          $("#TOTAL").html(array[2]);
          $("#txtTotal").val(array[3]);
        }
      });
      return false;
    }
    $("#btn-finalizar").click(function() {
      var pedido = $("#folio").val();
      var total = $("#txtTotal").val();
      //alert(total);
      var url = 'finalizar_pedido.php';
      if (pedido == "") {
        alertify.error("No existe un folio iniciado");
      } else {
        swal("Cantidad para liquidar", {
            content: "input",
          })
          .then((value) => {
            var cantidad = value;
            $.ajax({
              type: "POST",
              url: url,
              data: {
                pedido: pedido,
                total: total,
                cantidad: cantidad
              },
              success: function(respuesta) {
                if (respuesta == "menor") {
                  swal("Hay un problema", "La cantidad para liquidar es menor al total del pedido", "error");
                } else {
                  swal("Finalizado", "El pedido #" + respuesta + " ha sido finalizado con éxito", "success");
                  $("#form_datos")[0].reset();
                  $("#folio_pedido").val("");
                  tabla_pedido();
                  totales();
                }
              }
            });

          });
      }
    })
  </script>
</body>

</html>