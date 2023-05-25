<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $date_now = date('Y-m-d');
  $fecha = strtotime('-1 day', strtotime($date_now));
  $fecha = date('Y-m-d', $fecha);
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
            <h3 class="box-title">Visualizacion de Faltantes</h3>
          </div>
          <div class="box-body">
            <form action="reporteexcel.php">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha Inicial:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_inicio" name="fecha_inicio" onchange="habilitar(this.value,$('#fecha_final').val())">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fecha_final">*Fecha Final:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_final" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_final" name="fecha_final" onchange="habilitar(($('#fecha_inicio').val()),(this.value))">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <a class="btn btn-warning" onclick="verificar($('#fecha_inicio').val(),$('#fecha_final').val());">Generar Tabla</a>
              <button type="submit" class="btn btn-warning" id="excel" disabled>Generar Excel</button>
          </form>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Faltantes de Morralla (Resumen)</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_faltantes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Monedas</th>
                        <th>Falt.DO</th>
                        <th>Falt.Arboledas</th>
                        <th>Falt.Villegas</th>
                        <th>Falt.Allende</th>
                        <th>Falt.Total</th>
                        <th>Valor</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>  
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
  <script src="https://code.highcharts.com/highcharts.js"></script>
<!-- Page script -->
<script>
  function habilitar(fecha_inicio,fecha_final){
    if (fecha_inicio != "" && fecha_final != "")
    {
        if (fecha_inicio > fecha_final)
        {
          alertify.error("Fecha Inicio es Mayor",2);
        }
        else if (fecha_inicio == fecha_final)
        {
          $("#excel").removeAttr('disabled');
        }
        else if (fecha_inicio < fecha_final)
        {
          $("#excel").removeAttr('disabled');
        }
    }
  }
</script>
<script>
  function verificar(fecha_inicio,fecha_final) {
    if(fecha_inicio == "" || fecha_final == "")
    {
      alertify.error("Verifica Campos",2);
    }
    else
    {
      if (fecha_inicio > fecha_final)
      {
        alertify.error("Fecha Inicio es Mayor",2);
      }
      else if (fecha_inicio == fecha_final)
      {
        cargar_tabla_faltantes(fecha_inicio,fecha_final);
        habilitar(fecha_inicio,fecha_final);
      }
      else if (fecha_inicio < fecha_final)
      {
        cargar_tabla_faltantes(fecha_inicio,fecha_final);
        habilitar(fecha_inicio,fecha_final);
      }
    }
  }
</script>
<script>
  function cargar_tabla_faltantes(fecha_inicio,fecha_final) {
    $('#lista_faltantes').dataTable().fnDestroy();
    $('#lista_faltantes').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "dom": 'Bfrtip',
         buttons: [
          {
						extend: 'pageLength',
						text: 'Registros',
						className: 'btn btn-default'
					},
					{
						extend: 'excel',
						text: 'Exportar a Excel',
						className: 'btn btn-default',
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'copy',
						text: 'Copiar registros',
						className: 'btn btn-default',
						copyTitle: 'Ajouté au presse-papiers',
						copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
						copySuccess: {
							_: '%d lignes copiées',
							1: '1 ligne copiée'
						}
					}
				],
        "ajax": {
            "type": "POST",
            "url": "tabla_faltantes.php",
            "dataSrc": "",
            "data":{'fecha_inicio':fecha_inicio,'fecha_final':fecha_final}
        },
        "columns": [
            { "data": "#" },
            { "data": "Monedas" },
            { "data": "FaltDO" },
            { "data": "FaltArboledas" },
            { "data": "FaltVillegas" },
            { "data": "FaltAllende" },
            { "data": "FaltTotal" },
            { "data": "Valor" }
        ]
    } );
  }
</script>
<script type="text/javascript">
      $('.form_datetime').datetimepicker({
          //language:  'fr',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          forceParse: 0,
          showMeridian: 1
      });
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
      $('.form_time').datetimepicker({
          language:  'fr',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 1,
          minView: 0,
          maxView: 1,
          forceParse: 0
      });
  </script>
</body>
</html>
