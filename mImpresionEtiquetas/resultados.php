<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
function ultimo_dia()
{
  $month = date('m');
  $year = date('Y');
  $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
  return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
};
/** Actual month first day **/
function primer_dia()
{
  $month = date('m');
  $year = date('Y');
  return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
}
$fecha1 = primer_dia($fecha);
$fecha2 = ultimo_dia($fecha);
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <style type="text/css">
    #container {
      min-width: 320px;
      max-width: 800px;
      margin: 0 auto;
    }
  </style>
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
        <div class="box box-danger" id="contenedor_tabla">
          <div class="box-header">
            <h3 class="box-title">Etiquetas | Resultados por Mes</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>

            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <label>*Fecha Inicio</label>
                <div class="input-group date form_date" data-date="<?php echo $fecha1 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                  <input class="form-control" size="16" type="text" value="<?php echo $fecha1 ?>" readonly name="fecha1" id="fecha1">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
              <div class="col-md-6">
                <label>*Fecha Final</label>
                <div class="input-group date form_date" data-date="<?php echo $fecha2 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                  <input class="form-control" size="16" type="text" value="<?php echo $fecha2 ?>" readonly name="fecha2" id="fecha2">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>

          </div>
          <div class="box-footer text-right">
            <a class="btn btn-warning" id="guardar" onclick="calcular()">Generar</a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-body">
                <div class="table-responsive">
                  <table id="lista_ranking" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="5%">Suc.</th>
                        <th>Usuario</th>
                        <th width="5%">Rkng</th>
                        <th width="5%">C.</th>
                        <th width="5%">S.</th>
                        <th width="5%">T.</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th width="5%">#</th>
                        <th width="10%">Sucursal</th>
                        <th>Usuario</th>
                        <th width="5%">Rkng</th>
                        <th width="5%">C.</th>
                        <th width="5%">S.</th>
                        <th width="5%">T.</th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Diaz Ordaz</h3>
                  </div>
                  <div class="box-body">
                    <div id="do_codigos" style="min-width: 210px; height: 140px; margin: 0 auto"></div>
                  </div>
                  <div class="box-footer">
                    <div class="row">
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="solicitados_do"></div>
                          </h5>
                          <span class="description-text">Solicitados</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="auditados_do">
                          </h5>
                          <span class="description-text">Correctos</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="escaneados_do"></div>
                          </h5>
                          <span class="description-text">Total</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Arboledas</h3>
                  </div>
                  <div class="box-body">
                    <div id="arb_codigos" style="min-width: 210px; height: 140px; margin: 0 auto"></div>
                  </div>
                  <div class="box-footer">
                    <div class="row">
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="solicitados_arb"></div>
                          </h5>
                          <span class="description-text">SOLICITADOS</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="auditados_arb">
                          </h5>
                          <span class="description-text">CORRECTOS</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="escaneados_arb"></div>
                          </h5>
                          <span class="description-text">Total</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Villegas</h3>
                  </div>
                  <div class="box-body">
                    <div id="vill_codigos" style="min-width: 210px; height: 140px; margin: 0 auto"></div>
                  </div>
                  <div class="box-footer">
                    <div class="row">
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="solicitados_vill"></div>
                          </h5>
                          <span class="description-text">SOLICITADOS</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="auditados_vill">
                          </h5>
                          <span class="description-text">CORRECTOS</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="escaneados_vill"></div>
                          </h5>
                          <span class="description-text">Total</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Allende</h3>
                  </div>
                  <div class="box-body">
                    <div id="all_codigos" style="min-width: 210px; height: 140px; margin: 0 auto"></div>
                  </div>
                  <div class="box-footer">
                    <div class="row">
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="solicitados_all"></div>
                          </h5>
                          <span class="description-text">SOLICITADOS</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="auditados_all">
                          </h5>
                          <span class="description-text">CORRECTOS</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="escaneados_all"></div>
                          </h5>
                          <span class="description-text">Total</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">La Petaca</h3>
                  </div>
                  <div class="box-body">
                    <div id="lp_codigos" style="min-width: 210px; height: 140px; margin: 0 auto"></div>
                  </div>
                  <div class="box-footer">
                    <div class="row">
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="solicitados_lp"></div>
                          </h5>
                          <span class="description-text">SOLICITADOS</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="auditados_lp">
                          </h5>
                          <span class="description-text">CORRECTOS</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <div class="col-sm-4 col-xs-4">
                        <div class="description-block">
                          <h5 class="description-header">
                            <div id="escaneados_lp"></div>
                          </h5>
                          <span class="description-text">Total</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row" id="resumen">

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
  <script src="https://code.highcharts.com/highcharts-more.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>


  <!-- Page script -->
  <script>
    $(document).ready(function() {
      totales();
    });

    function generar() {
      var fecha1 = $('#fecha1').val();
      var fecha2 = $('#fecha2').val();

      $.ajax({
        type: "POST",
        dataType: "json",
        url: 'datos.php',
        data: {
          'fecha1': fecha1,
          'fecha2': fecha2
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var options = {
            chart: {
              renderTo: 'grafica',
              type: 'column'
            },
            title: {
              text: 'LAS SUCURSALES QUE MAS PARTICIPAN EN ORDEN'
            },
            subtitle: {
              text: ''
            },
            xAxis: {
              type: 'category'
            },
            yAxis: {
              title: {
                text: 'Solicitudes'
              }
            },
            legend: {
              enabled: false
            },
            colors: ['#DD4B39', '#00A65A', '#0073B7', '#605CA8'],
            plotOptions: {
              series: {
                borderWidth: 0,
                dataLabels: {
                  enabled: true
                }
              },
              column: {
                colorByPoint: true
              }
            },
            tooltip: {
              headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
              pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
            },
            series: [{}]
          };
          options.series[0].data = respuesta;
          var chart = new Highcharts.Chart(options);
        }
      });
    }

    function generar2() {
      var fecha1 = $('#fecha1').val();
      var fecha2 = $('#fecha2').val();
      $('#lista_ranking').dataTable().fnDestroy();
      $('#lista_ranking').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "lengthMenu": [
          [10],
          ["Todo"]
        ],
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
		            title: 'Lista-Modulos',
		            exportOptions: {
		              columns: ':visible'
		            }
		          },
		          {
		            extend: 'pdf',
		            text: 'Exportar a PDF',
		            className: 'btn btn-default',
		            title: 'Lista-Modulos',
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
          "url": "datos2.php",
          "dataSrc": "",
          "data": {
            'fecha1': fecha1,
            'fecha2': fecha2
          }
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "Sucursal"
          },
          {
            "data": "Usuario"
          },
          {
            "data": "Ranking"
          },
          {
            "data": "Correcto"
          },
          {
            "data": "Solicitado"
          },
          {
            "data": "Total"
          }
        ]
      });
    }

    function generar3() {
      var fecha1 = $('#fecha1').val();
      var fecha2 = $('#fecha2').val();
      $.ajax({
        type: "POST",
        dataType: "html",
        url: 'datos3.php',
        data: {
          'fecha1': fecha1,
          'fecha2': fecha2
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#resumen').html(respuesta);
        }
      });
    }

    function calcular() {
      generar3();
      generar2();
      generar();
      totales();
    }
    calcular();
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

    function totales() {
      var fecha_inicio = $("#fecha1").val();
      var fecha_fin = $("#fecha2").val();
      var url = "totales.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          fecha_inicio: fecha_inicio,
          fecha_fin: fecha_fin
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#solicitados_do').html(array[0]);
          $('#auditados_do').html(array[1]);
          $('#solicitados_arb').html(array[2]);
          $('#auditados_arb').html(array[3]);
          $('#solicitados_vill').html(array[4]);
          $('#auditados_vill').html(array[5]);
          $('#solicitados_all').html(array[6]);
          $('#auditados_all').html(array[7]);
          $('#escaneados_do').html(array[8]);
          $('#escaneados_arb').html(array[9]);
          $('#escaneados_vill').html(array[10]);
          $('#escaneados_all').html(array[11]);
          $("#solicitados_lp").html(array[12]);
          $("#auditados_lp").html(array[13]);
          $("#escaneados_lp").html(array[14]);
        }
      });
      return false;
    }
    var fi = $("#fecha1").val();
    var ff = $("#fecha2").val();
    Highcharts.chart('do_codigos', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
      },
      title: {
        text: '',
        align: 'center',
        verticalAlign: 'middle',
        y: 40
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:,.2f}%</b>'
      },
      plotOptions: {
        pie: {
          dataLabels: {
            enabled: true,
            distance: -50,
            style: {
              fontWeight: 'bold',
              color: 'white'
            }
          },
          startAngle: -90,
          endAngle: 90,
          center: ['50%', '100%'],
          size: '210%'
        }
      },
      series: [{
        type: 'pie',
        name: 'Etiquetas',
        innerSize: '60%',
        data: [<?php include 'codigos_do.php' ?>]
      }]
    });
    Highcharts.chart('arb_codigos', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
      },
      title: {
        text: '',
        align: 'center',
        verticalAlign: 'middle',
        y: 40
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:,.2f}%</b>'
      },
      plotOptions: {
        pie: {
          dataLabels: {
            enabled: true,
            distance: -50,
            style: {
              fontWeight: 'bold',
              color: 'white'
            }
          },
          startAngle: -90,
          endAngle: 90,
          center: ['50%', '100%'],
          size: '210%'
        }
      },
      series: [{
        type: 'pie',
        name: 'Etiquetas',
        innerSize: '60%',
        data: [<?php include 'codigos_arb.php'; ?>]
      }]
    });
    Highcharts.chart('vill_codigos', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
      },
      title: {
        text: '',
        align: 'center',
        verticalAlign: 'middle',
        y: 40
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:,.2f}%</b>'
      },
      plotOptions: {
        pie: {
          dataLabels: {
            enabled: true,
            distance: -50,
            style: {
              fontWeight: 'bold',
              color: 'white'
            }
          },
          startAngle: -90,
          endAngle: 90,
          center: ['50%', '100%'],
          size: '210%'
        }
      },
      series: [{
        type: 'pie',
        name: 'Etiquetas',
        innerSize: '60%',
        data: [<?php include 'codigos_vill.php'; ?>]
      }]
    });
    Highcharts.chart('all_codigos', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
      },
      title: {
        text: '',
        align: 'center',
        verticalAlign: 'middle',
        y: 40
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:,.2f}%</b>'
      },
      plotOptions: {
        pie: {
          dataLabels: {
            enabled: true,
            distance: -50,
            style: {
              fontWeight: 'bold',
              color: 'white'
            }
          },
          startAngle: -90,
          endAngle: 90,
          center: ['50%', '100%'],
          size: '210%'
        }
      },
      series: [{
        type: 'pie',
        name: 'Etiquetas',
        innerSize: '60%',
        data: [<?php include 'codigos_all.php'; ?>]
      }]
    });
    Highcharts.chart('lp_codigos', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
      },
      title: {
        text: '',
        align: 'center',
        verticalAlign: 'middle',
        y: 40
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:,.2f}%</b>'
      },
      plotOptions: {
        pie: {
          dataLabels: {
            enabled: true,
            distance: -50,
            style: {
              fontWeight: 'bold',
              color: 'white'
            }
          },
          startAngle: -90,
          endAngle: 90,
          center: ['50%', '100%'],
          size: '210%'
        }
      },
      series: [{
        type: 'pie',
        name: 'Etiquetas',
        innerSize: '60%',
        data: [<?php include 'codigos_lp.php'; ?>]
      }]
    });
  </script>
</body>

</html>