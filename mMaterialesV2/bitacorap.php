<?php
  include '../global_seguridad/verificar_sesion.php';
  function _data_last_month_day(){
    $month = date('m');
    $year = date('Y');
    $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));

    return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
  };

  /** Actual month first day **/
  function _data_first_month_day(){
    $month = date('m');
    $year = date('Y');
    return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
  }

  $fecha1 = _data_first_month_day();
  $fecha2 = _data_last_month_day();
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
    <?php include 'menuV4.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Materiales | Bitacora Pedidos</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-6">
                <div class="form-group">
                  <label>*Fecha 1:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha1 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha1 ?>" readonly name="fecha1" id="fecha1" onchange="cargar_tabla()">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>                  
                </div>
              </div>
              <div class="col-md-6">
                <label>*Fecha 2:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha2 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha2 ?>" readonly name="fecha2" id="fecha2" onchange="cargar_tabla()">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
              </div>
            </div>
          </div>
          <div class="row">
           <div class="col-md-12">
              <div class="table-responsive">
                <table id="lista_bitacora" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Solicita</th>
                      <th>Sucursal</th>
                      <th>Fecha</th>
                      <th>Estatus</th>
                      <th>Ver Pedido</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Solicita</th>
                      <th>Sucursal</th>
                      <th>Fecha</th>
                      <th>Estatus</th>
                      <th>Ver Pedido</th>
                    </tr>
                  </tfoot>
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

<?php include '../footer.php';?>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  function cargar_tabla(){
    var fecha1 = $('#fecha1').val();
    var fecha2 = $('#fecha2').val();

    $('#lista_bitacora').dataTable().fnDestroy();
    $('#lista_bitacora thead th').each( function () {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%" />' );
    });
    var table = $('#lista_bitacora').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "paging":   false,
      "dom": 'Bfrtip',
      buttons: [{
          extend: 'pageLength',
          text: 'Registros',
          className: 'btn btn-default'
        },
        {
          extend: 'excel',
          text: 'Exportar a Excel',
          className: 'btn btn-default',
          title: 'Bitacora Pedidos',
          exportOptions: {
            columns: ':visible'
          }
        },
        {
          extend: 'pdf',
          text: 'Exportar a PDF',
          className: 'btn btn-default',
          title: 'Bitacora Pedidos',
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
        "url": "tabla_bitacorap.php",
        "dataSrc": "",
        "data": {'fecha1':fecha1, 'fecha2':fecha2}
      },
      "columns": [
        { "data": "#", "width": "5%" },
        { "data": "Nombre" },
        { "data": "Solicita"},
        { "data": "Sucursal", "width": "10%"},
        { "data": "Fecha", "width": "10%" },
        { "data": "Estatus", "width": "10%" },
        { "data": "VerPedido", "width": "10%" }
      ]
    });
    table.columns().every( function () {
      var that = this;
      $( 'input', this.header() ).on( 'keyup change', function () {
        if ( that.search() !== this.value ) {
          that
            .search( this.value )
            .draw();
        }
      });
    });
  }
  $(function (){
   cargar_tabla();
  })
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
