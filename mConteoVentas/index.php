<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
</head>
<style>
  #modal_detalle {
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
                <h3 class="box-title">Resumen de ventas | Filtros</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="fecha_inicio">*Fecha:</label>
                      <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha" data-link-format="yyyy-mm-dd">
                        <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha" name="fecha">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="rango">*Rango (minutos)</label>
                      <input type="number" id="rango" name="rango" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button id="btn-buscar" class="btn btn-danger">Visualizar información</button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Resumen de Ventas | Conteo de tickets por lapso</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table id="lista_conteo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <th>Rango</th>
                          <th>Diaz Ordaz</th>
                          <th>Arboledas</th>
                          <th>Villegas</th>
                          <th>Allende</th>
                          <th>La Petaca</th>
                        </thead>
                      </table>
                    </div>
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
      cargar_tabla(0);
    });

    function cargar_tabla(estado) {
      var fecha = $("#fecha").val();
      var rango = $("#rango").val();
      $('#lista_conteo').dataTable().fnDestroy();
      $('#lista_conteo').DataTable({
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
          "url": "tabla_conteo.php",
          "dataSrc": "",
          "data": {
            fecha: fecha,
            rango: rango,
            estado: estado
          },
        },
        "columns": [{
            "data": "hora"
          },
          {
            "data": "DO"
          },
          {
            "data": "ARB"
          },
          {
            "data": "VILL"
          },
          {
            "data": "ALL"
          },
          {
            "data": "LP"
          }
        ]
      });
    };
    $("#btn-buscar").click(function(){
      cargar_tabla(1);
    });
  </script>
</body>

</html>