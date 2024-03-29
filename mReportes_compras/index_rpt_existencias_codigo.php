<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <script src="funciones.js?v=<?php echo (rand()); ?>"></script>
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
            <h3 class="box-title">Reportes | Existencias por codigo</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="frmDatosComprasVsVentas" action="reportes/rpt_existencias_codigo.php">
              <div class="row">
                <div class="col-lg-3">
                  <label for="">Sucursal</label>
                  <select class="form-control" name="sucursal" id="sucursal">
                    <option selected disabled value="">Seleccione...</option>
                    <option value="1">Diaz Ordaz</option>
                    <option value="2">Arboledas</option>
                    <option value="3">Villegas</option>
                    <option value="4">Allende</option>
                    <option value="5">Petaca</option>
                    <option value="6">Montemorelos</option>
                    <option value="99">CEDIS</option>
                  </select>
                </div>
                <div class="col-lg-3">
                  <div class="form-group">
                    <label for="">Archivo</label>
                    <input type="file" name="excel">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-3">
                  <label for="">Departamento</label>
                  <select class="form-control select2" name="departamento" id="departamento">
                    <option></option>
                  </select>
                </div>
                <div class="col-lg-3">
                  <label for="">Familia</label>
                  <select name="familia" id="familia" class="form-control select2">
                    <option></option>
                  </select>
                </div>
              </div>
              <input type="hidden" name="array" class="form-control" id="array_compras_vs">
          </div>
          <div class="box-footer text-right">
            <!-- <button class="btn btn-warning" id="mostrar_datos">Mostrar datos</button> -->
            <a href="javascript:subir_excel($('#frmDatosComprasVsVentas').attr('id'), $('#array_compras_vs').attr('id'))" class="btn btn-danger">Subir</a>
            <input type="submit" value="Generar Excel" class="btn btn-danger">
            <a href="#" onclick="mostrar_datos()" class="btn btn-danger">Mostrar tabla</a>

          </div>
          </form>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Registros</h3>
          </div>
          <div class="box-body">
            <div id="contenedor"></div>
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

  <script type="text/javascript">
    $('.form_datetime').datetimepicker({
      //language:  'fr',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1
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
    $('.form_time').datetimepicker({
      language: 'fr',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 1,
      minView: 0,
      maxView: 1,
      forceParse: 0
    });
  </script>
  <!--   <script>
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })

</script> -->
  <script>
    $(function() {
      $('#departamento').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "consulta_departamentos.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term // search term
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
    })
  </script>
  <script>
    $(function() {
      $('#familia').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "consulta_familias.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term // search term
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
    })
  </script>
  <script>
    $(function() {
      $('#proveedor').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "consulta_proveedores.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term // search term
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
    })
  </script>

</body>

</html>