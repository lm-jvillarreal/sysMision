<?php
include '../global_seguridad/verificar_sesion.php';
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
            <h3 class="box-title">Monitoreo Sistemas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_inicio">*Rango 1</label>
                  <input type="text" class="form-control pull-right" id="fecha1" name="fecha1">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_final">*Rango 2</label>
                  <input type="text" class="form-control pull-right" id="fecha2" name="fecha2">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_final">*Sucursal</label>
                  <select name="sucursal" id="sucursal" class="form-control" onchange="cargar();"></select>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <a onclick="limpiar();" class="btn btn-danger">Limpiar</a>
              <a onclick="cargar();" class="btn btn-warning">Generar</a>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <!-- <h3 class="box-title">Lista de Entradas</h3> -->
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-light-blue"><i class="fa fa-sign-in fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Entradas Totales</span>
                    <span class="info-box-number" id="auditoria_entradas">0</span>
                    <i id="icono_entrada" class='fa fa-xs'></i> <label id="entrada_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-purple"><i class="fa fa-arrows-h fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Mov. Totales</span>
                    <span class="info-box-number" id="movimientos_totales">0</span>
                    <i id="icono_movimiento" class='fa fa-xs'></i> <label id="movimiento_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-blue"><i class="fa fa-undo fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Devoluciones</span>
                    <span class="info-box-number" id="devoluciones">0</span>
                    <i id="icono_devoluciones" class='fa fa-xs'></i> <label id="devoluciones_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-yellow"><i class="fa fa-file-text fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Cartas Faltantes</span>
                    <span class="info-box-number" id="cartas_faltantes">0</span>
                    <i id="icono_cf" class='fa fa-xs'></i> <label id="cf_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-red"><i class="fa fa-times-circle fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Errores</span>
                    <span class="info-box-number" id="errores">0</span>
                    <i id="icono_e" class='fa fa-xs'></i> <label id="e_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-green"><i class="fa fa-clock-o fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Conciliaciones LE</span>
                    <span class="info-box-number" id="te">0</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-red"><i class="fa fa-clock-o fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Tiempo Permiso</span>
                    <span class="info-box-number" id="tp">0</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-maroon"><i class="fa fa-tags fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Etiquetas Impresas</span>
                    <span class="info-box-number" id="etiquetas_i">0</span>
                    <i id="icono_impresas" class='fa fa-xs'></i> <label id="impresas_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-navy"><i class="fa fa-envelope-open fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Pedido Materiales</span>
                    <span class="info-box-number" id="materiales_p">0</span>
                    <i id="icono_materiales" class='fa fa-xs'></i> <label id="materiales_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-teal"><i class="fa fa-adn fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Altas Registradas</span>
                    <span class="info-box-number" id="altas">0</span>
                    <i id="icono_altas" class='fa fa-xs'></i> <label id="altas_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-light-blue"><i class="fa fa-opera fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Ofertas</span>
                    <span class="info-box-number" id="ofertas">0</span>
                    <i id="icono_ofertas" class='fa fa-xs'></i> <label id="ofertas_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-purple"><i class="fa fa-refresh fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Cambios</span>
                    <span class="info-box-number" id="cambios">0</span>
                    <i id="icono_cambios" class='fa fa-xs'></i> <label id="cambios_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-blue"><i class="fa fa-sticky-note fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Notas de Cargo</span>
                    <span class="info-box-number" id="notas">0</span>
                    <i id="icono_notas" class='fa fa-xs'></i> <label id="notas_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-yellow"><i class="fa fa-pencil-square fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Dev. P/ Correccion</span>
                    <span class="info-box-number" id="dev">0</span>
                    <i id="icono_dev" class='fa fa-xs'></i> <label id="dev_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-green"><i class="fa fa-check-square fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Inf.Mov. Asociados</span>
                    <span class="info-box-number" id="infmovaso">0</span>
                    <i id="icono_infmovaso" class='fa fa-xs'></i> <label id="infmovaso_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-red"><i class="fa fa-window-close fa-lg"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Inf.Mov. Cancelados</span>
                    <span class="info-box-number" id="infmovcan">0</span>
                    <i id="icono_infmovcan" class='fa fa-xs'></i> <label id="infmovcan_porcentaje">0 %</label>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
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

  <script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>
  <!-- Page script -->
  <script>
    $(function() {
      $('#sucursal').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "combo_sucursales.php",
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

    function cargar() {
      var sucursal = $('#sucursal').val();
      var fecha1 = $("#fecha1").val();
      var fecha2 = $("#fecha2").val();

      if (sucursal != null && fecha1 != "") {
        $.ajax({
          type: "POST",
          url: 'datos.php',
          data: {
            'fecha1': fecha1,
            'fecha2': fecha2,
            'sucursal': sucursal
          },
          success: function(respuesta) {
            quitarclass();
            var array = eval(respuesta);
            $('#auditoria_entradas').html(array[0]);
            $('#entrada_porcentaje').html(array[1]);
            icono1 = (array[2] == "menor") ? "fa-arrow-down text-red" : (array[2] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_entrada').addClass(icono1);

            $('#movimientos_totales').html(array[3]);
            $('#movimiento_porcentaje').html(array[4]);
            icono2 = (array[5] == "menor") ? "fa-arrow-down text-red" : (array[5] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_movimiento').addClass(icono2);

            $('#devoluciones').html(array[6]);
            $('#devoluciones_porcentaje').html(array[7]);
            icono3 = (array[8] == "menor") ? "fa-arrow-down text-red" : (array[8] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_devoluciones').addClass(icono3);

            $('#cartas_faltantes').html(array[9]);
            $('#cf_porcentaje').html(array[10]);
            icono4 = (array[11] == "menor") ? "fa-arrow-down text-red" : (array[11] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_cf').addClass(icono4);

            $('#errores').html(array[12]);
            $('#e_porcentaje').html(array[13]);
            icono5 = (array[14] == "menor") ? "fa-arrow-down text-red" : (array[14] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_e').addClass(icono5);

            $('#te').html(array[15]);
            $('#tp').html(array[16]);

            $('#etiquetas_i').html(array[17]);
            $('#impresas_porcentaje').html(array[18]);
            icono6 = (array[19] == "menor") ? "fa-arrow-down text-red" : (array[19] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_impresas').addClass(icono6);

            $('#materiales_p').html(array[20]);
            $('#materiales_porcentaje').html(array[21]);
            icono7 = (array[22] == "menor") ? "fa-arrow-down text-red" : (array[22] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_materiales').addClass(icono7);

            $('#altas').html(array[23]);
            $('#altas_porcentaje').html(array[24]);
            icono8 = (array[25] == "menor") ? "fa-arrow-down text-red" : (array[25] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_altas').addClass(icono8);

            $('#cambios').html(array[26]);
            $('#cambios_porcentaje').html(array[27]);
            icono9 = (array[28] == "menor") ? "fa-arrow-down text-red" : (array[28] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_cambios').addClass(icono9);

            $('#ofertas').html(array[29]);
            $('#ofertas_porcentaje').html(array[30]);
            icono10 = (array[31] == "menor") ? "fa-arrow-down text-red" : (array[31] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_ofertas').addClass(icono10);

            $('#notas').html(array[32]);
            $('#notas_porcentaje').html(array[33]);
            icono11 = (array[34] == "menor") ? "fa-arrow-down text-red" : (array[34] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_notas').addClass(icono11);

            $('#dev').html(array[35]);
            $('#dev_porcentaje').html(array[36]);
            icono12 = (array[37] == "menor") ? "fa-arrow-down text-red" : (array[37] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_dev').addClass(icono12);

            $('#infmovaso').html(array[38]);
            $('#infmovaso_porcentaje').html(array[39]);
            icono13 = (array[40] == "menor") ? "fa-arrow-down text-red" : (array[40] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_infmovaso').addClass(icono13);

            $('#infmovcan').html(array[41]);
            $('#infmovcan_porcentaje').html(array[42]);
            icono14 = (array[43] == "menor") ? "fa-arrow-down text-red" : (array[43] == "igual") ? "fa-minus" : "fa-arrow-up text-green";
            $('#icono_infmovcan').addClass(icono14);
          }
        });
      } else {
        alertify.error("Verifica Campos");
      }
      return false;
    }

    function quitarclass() {
      if ($('#icono_entrada').hasClass('fa-arrow-down')) {
        $('#icono_entrada').removeClass('fa-arrow-down');
      } else {
        $('#icono_entrada').removeClass('fa-arrow-up');
        $('#icono_entrada').removeClass('fa-minus');
      }

      if ($('#icono_entrada').hasClass('text-green')) {
        $('#icono_entrada').removeClass('text-green');
      } else {
        $('#icono_entrada').removeClass('text-red');
      }

      if ($('#icono_movimiento').hasClass('fa-arrow-down')) {
        $('#icono_movimiento').removeClass('fa-arrow-down');
      } else {
        $('#icono_movimiento').removeClass('fa-arrow-up');
        $('#icono_movimiento').removeClass('fa-minus');
      }

      if ($('#icono_movimiento').hasClass('text-green')) {
        $('#icono_movimiento').removeClass('text-green');
      } else {
        $('#icono_movimiento').removeClass('text-red');
      }

      if ($('#icono_devoluciones').hasClass('fa-arrow-down')) {
        $('#icono_devoluciones').removeClass('fa-arrow-down');
      } else {
        $('#icono_devoluciones').removeClass('fa-arrow-up');
        $('#icono_devoluciones').removeClass('fa-minus');
      }

      if ($('#icono_devoluciones').hasClass('text-green')) {
        $('#icono_devoluciones').removeClass('text-green');
      } else {
        $('#icono_devoluciones').removeClass('text-red');
      }

      if ($('#icono_cf').hasClass('fa-arrow-down')) {
        $('#icono_cf').removeClass('fa-arrow-down');
      } else {
        $('#icono_cf').removeClass('fa-arrow-up');
        $('#icono_cf').removeClass('fa-minus');
      }

      if ($('#icono_cf').hasClass('text-green')) {
        $('#icono_cf').removeClass('text-green');
      } else {
        $('#icono_cf').removeClass('text-red');
      }

      if ($('#icono_e').hasClass('fa-arrow-down')) {
        $('#icono_e').removeClass('fa-arrow-down');
      } else {
        $('#icono_e').removeClass('fa-arrow-up');
        $('#icono_e').removeClass('fa-minus');
      }

      if ($('#icono_e').hasClass('text-green')) {
        $('#icono_e').removeClass('text-green');
      } else {
        $('#icono_e').removeClass('text-red');
      }

      if ($('#icono_impresas').hasClass('fa-arrow-down')) {
        $('#icono_impresas').removeClass('fa-arrow-down');
      } else {
        $('#icono_impresas').removeClass('fa-arrow-up');
        $('#icono_impresas').removeClass('fa-minus');
      }

      if ($('#icono_impresas').hasClass('text-green')) {
        $('#icono_impresas').removeClass('text-green');
      } else {
        $('#icono_impresas').removeClass('text-red');
      }

      if ($('#icono_materiales').hasClass('fa-arrow-down')) {
        $('#icono_materiales').removeClass('fa-arrow-down');
      } else {
        $('#icono_materiales').removeClass('fa-arrow-up');
        $('#icono_materiales').removeClass('fa-minus');
      }

      if ($('#icono_materiales').hasClass('text-green')) {
        $('#icono_materiales').removeClass('text-green');
      } else {
        $('#icono_materiales').removeClass('text-red');
      }

      if ($('#icono_altas').hasClass('fa-arrow-down')) {
        $('#icono_altas').removeClass('fa-arrow-down');
      } else {
        $('#icono_altas').removeClass('fa-arrow-up');
        $('#icono_altas').removeClass('fa-minus');
      }

      if ($('#icono_altas').hasClass('text-green')) {
        $('#icono_altas').removeClass('text-green');
      } else {
        $('#icono_altas').removeClass('text-red');
      }

      if ($('#icono_cambios').hasClass('fa-arrow-down')) {
        $('#icono_cambios').removeClass('fa-arrow-down');
      } else {
        $('#icono_cambios').removeClass('fa-arrow-up');
        $('#icono_cambios').removeClass('fa-minus');
      }

      if ($('#icono_cambios').hasClass('text-green')) {
        $('#icono_cambios').removeClass('text-green');
      } else {
        $('#icono_cambios').removeClass('text-red');
      }

      if ($('#icono_ofertas').hasClass('fa-arrow-down')) {
        $('#icono_ofertas').removeClass('fa-arrow-down');
      } else {
        $('#icono_ofertas').removeClass('fa-arrow-up');
        $('#icono_ofertas').removeClass('fa-minus');
      }

      if ($('#icono_ofertas').hasClass('text-green')) {
        $('#icono_ofertas').removeClass('text-green');
      } else {
        $('#icono_ofertas').removeClass('text-red');
      }

      if ($('#icono_notas').hasClass('fa-arrow-down')) {
        $('#icono_notas').removeClass('fa-arrow-down');
      } else {
        $('#icono_notas').removeClass('fa-arrow-up');
        $('#icono_notas').removeClass('fa-minus');
      }

      if ($('#icono_notas').hasClass('text-green')) {
        $('#icono_notas').removeClass('text-green');
      } else {
        $('#icono_notas').removeClass('text-red');
      }

      if ($('#icono_dev').hasClass('fa-arrow-down')) {
        $('#icono_dev').removeClass('fa-arrow-down');
      } else {
        $('#icono_dev').removeClass('fa-arrow-up');
        $('#icono_dev').removeClass('fa-minus');
      }

      if ($('#icono_dev').hasClass('text-green')) {
        $('#icono_dev').removeClass('text-green');
      } else {
        $('#icono_dev').removeClass('text-red');
      }

      if ($('#icono_infmovaso').hasClass('fa-arrow-down')) {
        $('#icono_infmovaso').removeClass('fa-arrow-down');
      } else {
        $('#icono_infmovaso').removeClass('fa-arrow-up');
        $('#icono_infmovaso').removeClass('fa-minus');
      }

      if ($('#icono_infmovaso').hasClass('text-green')) {
        $('#icono_infmovaso').removeClass('text-green');
      } else {
        $('#icono_infmovaso').removeClass('text-red');
      }

      if ($('#icono_infmovcan').hasClass('fa-arrow-down')) {
        $('#icono_infmovcan').removeClass('fa-arrow-down');
      } else {
        $('#icono_infmovcan').removeClass('fa-arrow-up');
        $('#icono_infmovcan').removeClass('fa-minus');
      }

      if ($('#icono_infmovcan').hasClass('text-green')) {
        $('#icono_infmovcan').removeClass('text-green');
      } else {
        $('#icono_infmovcan').removeClass('text-red');
      }
    }
  </script>
  <script type="text/javascript">
    function limpiar() {
      $('#fecha2').val("");
    }
    var fecha_actual = new Date().toJSON().slice(0, 10);
    $('#fecha2').daterangepicker({
      "locale": {
        "format": "YYYY-MM-DD",
        "separator": " - ",
        "applyLabel": "Guardar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Personalizar",
        "daysOfWeek": [
          "Do",
          "Lu",
          "Ma",
          "Mi",
          "Ju",
          "Vi",
          "Sa"
        ],
        "monthNames": [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Setiembre",
          "Octubre",
          "Noviembre",
          "Diciembre"
        ],
        "firstDay": 1
      },
      "startDate": fecha_actual,
      "endDate": fecha_actual,
      "opens": "center"
    });

    $('#fecha1').daterangepicker({
      "locale": {
        "format": "YYYY-MM-DD",
        "separator": " - ",
        "applyLabel": "Guardar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Personalizar",
        "daysOfWeek": [
          "Do",
          "Lu",
          "Ma",
          "Mi",
          "Ju",
          "Vi",
          "Sa"
        ],
        "monthNames": [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Setiembre",
          "Octubre",
          "Noviembre",
          "Diciembre"
        ],
        "firstDay": 1
      },
      "startDate": fecha_actual,
      "endDate": fecha_actual,
      "opens": "center"
    });
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
</body>

</html>