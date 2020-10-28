<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
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
            <h3 class="box-title">Reportes | Notas de Crédito</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datoss" action="rpt_notascre.php">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha de inicio:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial" name="fecha_inicial">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_fin">*Fecha final:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly id="fecha_final" name="fecha_final">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="estatus">*Estatus:</label>
                  <select name="estatus" id="estatus" class="form-control select">
                    <option value=""></option>
                    <option value="1">Autorizada Sin Asignar</option>
                    <option value="2">Autorizada y Asignada</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <input type="submit" value="Generar Excel" class="btn btn-danger">
          </div>
          </form>
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
<script type="text/javascript">
  $('.form_date').datetimepicker({
    language:  'es',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
  });
  $(function () {
    $('.select').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })
</script>
</body>
</html>
