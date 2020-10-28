<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');

function _data_last_month_day()
{
  $month = date('m');
  $year = date('Y');
  $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));

  return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
};

/** Actual month first day **/
function _data_first_month_day()
{
  $month = date('m');
  $year = date('Y');
  return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
}

$fecha1 = _data_first_month_day();
$fecha2 =  _data_last_month_day();
?>
<!DOCTYPE html>
<html>


<head>
  <?php include '../head.php'; ?>
  <!-- <script src="funciones.js"></script> -->
  <link rel="stylesheet" href="../plugins/VenoBox-master/venobox/venobox.css" type="text/css" media="screen" />
</head>

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
        <div class=" box box-danger">
          <div class="box-header">
            <div class="col-lg-12">
              <h3 class="box-title">Control de Promotores | Bitacora</h3>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-4">
                  <label>*Fecha Inicio</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly name="fecha1" id="fecha1" onchange="generar()">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="col-md-4">
                  <label>*Fecha Final</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly name="fecha2" id="fecha2" onchange="generar()">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="">*Sucursal</label>
                  <br>
                  <select name="sucursal" id="sucursal" style="width: 100%"></select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-danger" id="btn-insertar" onclick="generar()">Generar</button>
          </div>
        </div>
        <div class=" box box-danger">
          <div class="box-header">
            <div class="col-lg-12">
              <h3 class="box-title">Control de Promotores | Resultados</h3>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div id="resultado" onmouseover="efecto();"></div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <div id="resultado2"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include '../footer2.php'; ?>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <!-- <div class="control-sidebar-bg"></div> -->
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
  <script src='../plugins/VenoBox-master/venobox/venobox.min.js'></script>
  <script>
    function efecto(){
      var test = $('.venobox').venobox();
      // close current item clicking on .closeme
      $(document).on('click', '.closeme', function(e){
        test.VBclose();
      });
      // go to next item in gallery clicking on .next
      $(document).on('click', '.next', function(e){
        test.VBnext();
      });
      // go to previous item in gallery clicking on .previous
      $(document).on('click', '.previous', function(e){
        test.VBprev();
      });
    }
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
       url: "consulta_sucursales.php",
       type: "post",
       dataType: 'json',
       delay: 250,
       data: function (params) {
        return {
          searchTerm: params.term
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
    function generar(){
      var fecha1   = $('#fecha1').val();
      var fecha2   = $('#fecha2').val();
      var sucursal = $('#sucursal').val();
      $.ajax({
        url: 'consulta_datos.php',
        data: {'fecha1':fecha1,
               'fecha2':fecha2,
               'sucursal':sucursal,
              },
        type: "POST",
        success: function(respuesta) {
          $('#resultado').html(respuesta);
        }
      });
      $.ajax({
        url: 'consulta_datos2.php',
        data: {'fecha1':fecha1,
               'fecha2':fecha2,
               'sucursal':sucursal,
              },
        type: "POST",
        success: function(respuesta) {
          $('#resultado2').html(respuesta);
        }
      });
    }
    function mostrar(numero){
      if($('.p'+numero).hasClass('hidden')){
        $('.p'+numero).removeClass('hidden');
      }else{
        $('.p'+numero).addClass('hidden');
      }
    }
    function mostrar2(numero){
      if($('.hor'+numero).hasClass('hidden')){
        $('.hor'+numero).removeClass('hidden');
      }else{
        $('.hor'+numero).addClass('hidden');
      }
    }
    function mostrar3(numero){
      if($('.mul'+numero).hasClass('hidden')){
        $('.mul'+numero).removeClass('hidden');
      }else{
        $('.mul'+numero).addClass('hidden');
      }
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