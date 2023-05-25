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
      <?php include 'menuV.php'; ?>
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
                <h3 class="box-title">Control de Pedidos | Registro</h3>
              </div>
              <div class="box-body">
                <form action="" method="POST" id="form_datos">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="nombre">*Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="telefono">*Teléfono</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                          </div>
                          <input type="text" name="telefono" id="telefono" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="tipo_pedido">*Tipo pedido</label>
                        <select name="tipo_pedido" id="tipo_pedido" class="form-control">
                          <option value=""></option>
                          <option value="DOMICILIO">Domicilio</option>
                          <option value="TIENDA">En Tienda</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="fecha_entrega">*Fecha entrega</label>
                        <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_entrega" data-link-format="yyyy-mm-dd">
                          <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha_entrega" name="fecha_entrega">
                          <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="colonia">*Colonia</label>
                        <input type="text" name="colonia" id="colonia" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="calle">*Calle</label>
                        <input type="text" name="calle" id="calle" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="numero">*Número</label>
                        <input type="text" name="numero_casa" id="numero_casa" class="form-control">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="box-footer">
                <div class="row">
                  <div class="col-md-6 text-left">
                    <button class="btn btn-danger" id="btn-detalle">Agregar artículos</button>
                  </div>
                  <div class="col-md-6 text-right">
                    <button class="btn btn-warning" id="btn-iniciar">Iniciar Pedido</button>
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
                <h3 class="box-title">Control de Pedidos | Detalle</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="folio_pedido">*Folio</label>
                      <input type="text" name="folio_pedido" id="folio_pedido" class="form-control" readonly="true">
                      <input type="hidden" name="txtSubtotal" id="txtSubtotal">
                      <input type="hidden" name="txtImpuestos" id="txtImpuestos">
                      <input type="hidden" name="txtTotal" id="txtTotal">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table id="lista_pedido" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <th width='15%'>Código</th>
                          <th>Descripción</th>
                          <th width='10%'>U.M.</th>
                          <th width='10%'>C.U.</th>
                          <th width='10%'>Cantidad</th>
                          <th width='10%'>Total</th>
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
      $('[data-mask]').inputmask();
      tabla_pedido();
    });
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
    $("#tipo_pedido").select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });

    $("#btn-iniciar").click(function() {
      var url = "iniciar_pedido.php";
      $.ajax({
        type: "POST",
        url: url,
        data: $("#form_datos").serialize(),
        success: function(respuesta) {
          $("#folio_pedido").val(respuesta);
          $("#btn-iniciar").attr("disabled", true);
        }
      });
      return false;
    });

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

    function tabla_pedido() {
      var folio_pedido = $("#folio_pedido").val();
      $('#lista_pedido').dataTable().fnDestroy();
      $('#lista_pedido').DataTable({
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
            "data": "codigo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "um"
          },
          {
            "data": "costo_unitario"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "total"
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
    $("#btn-detalle").click(function() {
      $("#modal-articulos").modal("show");
    });

    function agregar(articulo, consecutivo) {
      var pedido = $("#folio_pedido").val();
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
            tabla_pedido();
            totales();
          }
        });
      }
      return false;
    }

    function totales() {
      var pedido = $("#folio_pedido").val();
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

    $("#btn-finalizar").click(function() {
      var pedido = $("#folio_pedido").val();
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