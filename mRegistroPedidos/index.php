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
                        <input type="text" name="nombre" id="nombre" class="form-control" required="true">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="telefono">*Teléfono</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                          </div>
                          <input type="text" name="telefono" id="telefono" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="metodo_pago">*Método pago</label>
                        <select name="metodo_pago" id="metodo_pago" class="form-control">
                          <option value=""></option>
                          <option value="EFECTIVO">Efectivo</option>
                          <option value="ELECTRONICO">Electrónico</option>
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
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="colonia">*Colonia</label>
                        <input type="text" name="colonia" id="colonia" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="calle">*Calle</label>
                        <input type="text" name="calle" id="calle" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="form-group">
                        <label for="numero">*Número</label>
                        <input type="number" name="numero_casa" id="numero_casa" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="entre_calles">*Entre calles:</label>
                        <input type="text" name="entre_calles" id="entre_calles" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="referencia">*Referencia:</label>
                        <input type="text" name="referencia" id="referencia" class="form-control" required>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="box-footer">
                <div class="text-right">
                  <button class="btn btn-warning" id="btn-iniciar">Iniciar Pedido</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
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
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="cantidad">Cantidad:</label>
                      <input type="number" id="cantidad" name="cantidad" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="descripcion">*Descripción</label>
                      <input type="text" id="descripcion" name="descripcion" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table id="lista_pedido" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <th>Descripción</th>
                          <th width='30%'>Cantidad</th>
                          <th width='5%'></th>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <div class="row">
                  <div class="col-md-6">
                    <button class="btn btn-danger" id="btn-cancelar">Cancelar Pedido</button>
                  </div>
                  <div class="col-md-6 text-right">
                    <button class="btn btn-success" id="btn-finalizar">Finalizar Pedido</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
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
    $("#metodo_pago").select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });

    $("#btn-iniciar").click(function() {
      var url = "iniciar_pedido.php";
      if ($("#nombre").val() == "" || $("#telefono").val() == "" || $("#metodo_pago").val() == "" || $("#fecha_entrega").val() == "" || $("#colonia").val() == "" || $("#calle").val() == "" || $("#numero_casa").val() == "" || $("#entre_calles").val() == "" || $("#referencia").val() == "") {
        alertify.error("Favor de rellenar todos los campos");
      } else {
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(),
          success: function(respuesta) {
            $("#folio_pedido").val(respuesta);
            $("#btn-iniciar").attr("disabled", true);
          }
        });
      }
      return false;
    });

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
            "data": "descripcion"
          },
          {
            "data": "cantidad"
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
        if ($("#folio_pedido").val() == "" || $("#cantidad").val() == "" || $("#descripcion").val() == "") {

        } else {
          agregar();
          $("#cantidad").val("");
          $("#descripcion").val("");
          $("#cantidad").focus();
        }
      }
    });

    function agregar() {
      var pedido = $("#folio_pedido").val();
      if (pedido == "") {
        alertify.error("No hay un pedido iniciado");
      } else {
        var cantidad = $("#cantidad").val();
        var articulo = $("#descripcion").val();
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
            $("#btn-iniciar").removeAttr("disabled");
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
    $("#btn-finalizar").click(function() {
      var folio_pedido = $("#folio_pedido").val();
      if (folio_pedido == "") {
        alertify.error("No existe un pedido iniciado");
      } else {
        var url = "finalizar_pedido.php";
        $.ajax({
          type: "POST",
          url: url,
          data: {
            folio_pedido: folio_pedido
          },
          success: function(respuesta) {
            $("#form_datos")[0].reset();
            $("#folio_pedido").val("");
            var tab = window.open('pedido_pdf.php?flp=' + folio_pedido, '_blank');
            if (tab) {
              tab.focus(); //ir a la pestaña
            } else {
              alertify.error('Pestañas bloqueadas, activa las ventanas emergentes (Popups)');
            }
            tabla_pedido();
          }
        });
        return false;
      }
    });
    $("#btn-cancelar").click(function() {
      var folio_pedido = $("#folio_pedido").val();
      var url = "cancelar_pedido.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio_pedido: folio_pedido
        },
        success: function(respuesta) {
          $("#form_datos")[0].reset();
          $("#folio_pedido").val("");
          tabla_pedido();
          alertify.success("Pedido cancelado");
        }
      });
      return false;
    })
  </script>
</body>

</html>