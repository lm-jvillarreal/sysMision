<?php
  include '../global_seguridad/verificar_sesion.php';
  function _data_last_month_day() { 
      $month = date('m');
      $year = date('Y');
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));
 
      return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  };
 
  /** Actual month first day **/
  function _data_first_month_day() {
      $month = date('m');
      $year = date('Y');
      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }
  
  $fecha1 = _data_first_month_day();
  $fecha2 =  _data_last_month_day();
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
    <?php include 'menuV5.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Participación Inventarios | Filtros</h3>
        </div>
        <div class="box-body">
          <div class="row">
          <div class="col-md-3">
              <div class="form-group">
                <label for="fecha_final">*Tipo</label>
                 <select name="tipo" id="tipo" class="form-control">
                    <option value=""></option>
                    <option value="1">Conteo Directo</option>
                    <option value="2">Capturados</option>
                 </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="fecha_final">*Sucursal</label>
                 <select name="sucursal" id="sucursal" class="form-control"></select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="fecha_inicio">*Fecha 1</label>
                <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                  <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly name="fecha1" id="fecha1">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="fecha_final">*Fecha 2</label>
                <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                  <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly name="fecha2" id="fecha2">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
          </div> 
          <div class="box-footer text-right">
            <button type='button' id='generar' class="btn btn-warning">Generar</button>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 id="cantidad">0</h3>
              <h4>Total de Mapeos</h4>
            </div>
            <div class="icon">
              <i class="fa fa-map"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 id="cantidad2">0</h3>
              <h4>Cantidad de Códigos Prelistados</h4>
            </div>
            <div class="icon">
              <i class="fa fa-barcode"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <div class="row">
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title"> Usuarios Mapeo | Top 3 </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12" id="tabla">
                        <div class="table-responsive">
                            <table id="tabla_usuarios_m" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                </tr>
                            </tbody>  
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6" id="tabla2">
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title"> Usuarios Conteo | Top 3 </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12" id="tabla">
                        <div class="table-responsive">
                            <table id="tabla_usuarios_c" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                </tr>
                            </tbody>  
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
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

<!-- Page script -->
<script>
  $(function(){
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
       url: "combo_sucursales.php",
       type: "post",
       dataType: 'json',
       delay: 250,
       data: function (params) {
        return {
          searchTerm: params.term // search term
        };
       },
       processResults: function (response) {
         return {
            results: response
         };
       },
       cache: true
      }
    })
    // consulta_datos();
  })
  function cargar_tabla(){
    var tipo = $('#tipo').val();
    var sucursal = $('#sucursal').val();
    var fecha1   = $("#fecha1").val();
    var fecha2   = $("#fecha2").val();

    $('#tabla_usuarios_m').dataTable().fnDestroy();
    $('#tabla_usuarios_m').DataTable( {
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
            title: 'Entradas Usuario',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Entradas Usuario',
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
        "url": "tabla_usuarios_m.php",
        "dataSrc": "",
        "data":{'fecha1':fecha1,'fecha2':fecha2,'sucursal':sucursal,'tipo':tipo},
      },
      "columns": [
        { "data": "#", "width":"3%" },
        { "data": "Usuario" },
        { "data": "Total", "width":"10%"}
      ]
    });
  }
  function cargar_tabla2(){
    var tipo = $('#tipo').val();
    var sucursal = $('#sucursal').val();
    var fecha1   = $("#fecha1").val();
    var fecha2   = $("#fecha2").val();

    $('#tabla_usuarios_c').dataTable().fnDestroy();
    $('#tabla_usuarios_c').DataTable( {
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
            title: 'Entradas Usuario',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Entradas Usuario',
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
        "url": "tabla_usuarios_c.php",
        "dataSrc": "",
        "data":{'fecha1':fecha1,'fecha2':fecha2,'sucursal':sucursal,'tipo':tipo},
      },
      "columns": [
        { "data": "#", "width":"3%"},
        { "data": "Usuario" },
        { "data": "Total", "width":"10%" }
      ]
    });
  }
  function consulta_datos(){
    var tipo = $('#tipo').val();
    var sucursal = $('#sucursal').val();
    var fecha1   = $("#fecha1").val();
    var fecha2   = $("#fecha2").val();

    $.ajax({
      type: "POST",
      dataType: "json",
      url: 'datos_codigos.php',
      data: {'fecha1':fecha1,'fecha2':fecha2,'sucursal':sucursal,'tipo':tipo}, // Adjuntar los campos del formulario enviado.
      // async: false,
      success: function(respuesta)
      {
        var array = eval(respuesta);
        $('#cantidad').html(array[0]);
        $('#cantidad2').html(array[1]);
      }
    });
  }
  $('#generar').click(function(){
    var tipo = $('#tipo').val();

    if(tipo == 1){
        consulta_datos();
        cargar_tabla();
        $('#tabla2').hide();
    }else{
        consulta_datos();
        cargar_tabla();
        cargar_tabla2();
        $('#tabla2').show();
    }
  })
    $('#tipo').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
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
