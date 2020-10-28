<?php
include '../global_seguridad/verificar_sesion.php';
$fecha_inicio = date("Y-m-01");
$fecha_fin = date("Y-m-d");
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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Resumen de Pedidos | Filtros</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha inicial:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha_inicio ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha_inicio ?>" id="fecha_inicio" name="fecha_inicio">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha final:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha_fin ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha_fin ?>" id="fecha_fin" name="fecha_fin">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>*Sucursal:</label>
                  <select name="sucursal" id="sucursal" class="form-control"></select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-consultar">Filtrar información</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Resumen de Pedidos | Resumen</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">pedidos realizados</span>
                    <span class="info-box-number" id="total_pedidos"></span>
                    <div class="progress">
                      <div class="progress-bar" id="pgrs_pedidos"></div>
                    </div>
                    <span class="progress-description" id="porc_pedidos">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Faltante Vs. Pedido</span>
                    <span class="info-box-number" id="total_noEnviado"></span>
                    <div class="progress">
                      <div class="progress-bar" id="pgrs_noEnviado"></div>
                    </div>
                    <span class="progress-description" id="porc_noEnviado">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Diferencia Vs. Pedido</span>
                    <span class="info-box-number" id="total_difPedido"></span>
                    <div class="progress">
                      <div class="progress-bar" id="pgrs_difPedido"></div>
                    </div>
                    <span class="progress-description" id="porc_difPedido">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Diferencia Vs. Traspaso</span>
                    <span class="info-box-number" id="total_difTraspaso"></span>
                    <div class="progress">
                      <div class="progress-bar" id="pgrs_difTraspaso"></div>
                    </div>
                    <span class="progress-description" id="porc_difTraspaso">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
            </div>
          </div>
          <div class="box-footer">
            *Las clasificaciones de los pedidos no son excluyentes.
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
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <!-- Page script -->
  <script>
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_sucursales.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      }
    })

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

    $("#btn-consultar").click(function(){
      cargar_totales();
    })
    
    function cargar_totales(){
      var url = "resumen_pedidos.php";
      var sucursal = $("#sucursal").val();
      var fecha_inicio = $("#fecha_inicio").val();
      var fecha_fin = $("#fecha_fin").val();
      $.ajax({
				type: "POST",
				url: url,
				data: {
					sucursal: sucursal,
					fecha_inicio: fecha_inicio,
					fecha_fin: fecha_fin
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					var array = eval(respuesta);
					$("#total_pedidos").html(array[0]);
					$("#pgrs_pedidos").attr("style", "width: " + array[1]);
					$("#porc_pedidos").html(array[2]);
          $("#total_noEnviado").html(array[3]);
					$("#pgrs_noEnviado").attr("style", "width: " + array[4]);
					$("#porc_noEnviado").html(array[5]);
          $("#total_difPedido").html(array[6]);
					$("#pgrs_difPedido").attr("style", "width: " + array[7]);
					$("#porc_difPedido").html(array[8]);
          $("#total_difTraspaso").html(array[9]);
					$("#pgrs_difTraspaso").attr("style", "width: " + array[10]);
					$("#porc_difTraspaso").html(array[11]);
				}
			});
			return false;
    }
  </script>
</body>

</html>