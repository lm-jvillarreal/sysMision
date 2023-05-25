<?php
include '../global_seguridad/verificar_sesion.php';
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
        <div class="row">
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Resumen de Aportaciones | Filtros</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="anio">*Año</label>
                      <input type="number" id="anio" name="anio" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="concepto">*Concepto</label>
                      <select name="lista_conceptos" id="lista_conceptos" class="form-control">
                        <option value=""></option>
                        <option value="APORTACION ANIVERSARIO">APORTACION ANIVERSARIO</option>
                        <option value="PLAN COMERCIAL">PLAN COMERCIAL</option>
                        <option value="APORTACION POR DIA DEL NIÑO">APORTACION DIA DEL NIÑO</option>
                        <option value="FONDOS">FONDOS</option>
                        <option value="APERTURA LA PETACA">APERTURA LA PETACA</option>
                        <option value="APERTURA MONTEMORELOS">APERTURA MONTEMORELOS</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button id="btn-consulta" class="btn btn-danger">Consultar</button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Proyección | Alejandro Ramirez</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="info-box bg-aqua">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">PROYECCIÓN</span>
                        <span class="info-box-number">
                          <div id="totalAR"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="prgrsAR"></div>
                        </div>
                        <span class="progress-description">
                          <div id="porcientoAR"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">APORTACIONES</span>
                        <span class="info-box-number">
                          <div id="AptotalAR"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="ApprgrsAR"></div>
                        </div>
                        <span class="progress-description">
                          <div id="ApporcientoAR"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Proyección | Juventino Reyna</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="info-box bg-aqua">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">PROYECCIÓN</span>
                        <span class="info-box-number">
                          <div id="totalJR"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="prgrsJR"></div>
                        </div>
                        <span class="progress-description">
                          <div id="porcientoJR"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">APORTACIONES</span>
                        <span class="info-box-number">
                          <div id="AptotalJR"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="ApprgrsJR"></div>
                        </div>
                        <span class="progress-description">
                          <div id="ApporcientoJR"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Proyección | Carlos Weinmann</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="info-box bg-aqua">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">PROYECCIÓN</span>
                        <span class="info-box-number">
                          <div id="totalCW"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="prgrsCW"></div>
                        </div>
                        <span class="progress-description">
                          <div id="porcientoCW"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">APORTACIONES</span>
                        <span class="info-box-number">
                          <div id="AptotalCW"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="ApprgrsCW"></div>
                        </div>
                        <span class="progress-description">
                          <div id="ApporcientoCW"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Proyección | Francisco Rodriguez</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="info-box bg-aqua">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">PROYECCIÓN</span>
                        <span class="info-box-number">
                          <div id="totalFR"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="prgrsFR"></div>
                        </div>
                        <span class="progress-description">
                          <div id="porcientoFR"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">APORTACIONES</span>
                        <span class="info-box-number">
                          <div id="AptotalFR"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="ApprgrsFR"></div>
                        </div>
                        <span class="progress-description">
                          <div id="ApporcientoFR"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Proyección |Gloria Charur</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="info-box bg-aqua">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">PROYECCIÓN</span>
                        <span class="info-box-number">
                          <div id="totalGC"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="prgrsGC"></div>
                        </div>
                        <span class="progress-description">
                          <div id="porcientoGC"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">APORTACIONES</span>
                        <span class="info-box-number">
                          <div id="AptotalGC"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="ApprgrsGC"></div>
                        </div>
                        <span class="progress-description">
                          <div id="ApporcientoGC"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Proyección |Jesús Hernandez</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="info-box bg-aqua">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">PROYECCIÓN</span>
                        <span class="info-box-number">
                          <div id="totalJB"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="prgrsJB"></div>
                        </div>
                        <span class="progress-description">
                          <div id="porcientoGB"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">APORTACIONES</span>
                        <span class="info-box-number">
                          <div id="AptotalJB"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="ApprgrsJB"></div>
                        </div>
                        <span class="progress-description">
                          <div id="ApporcientoJB"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Proyección |Manuel Cuevas</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="info-box bg-aqua">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">PROYECCIÓN</span>
                        <span class="info-box-number">
                          <div id="totalMC"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="prgrsMC"></div>
                        </div>
                        <span class="progress-description">
                          <div id="porcientoMC"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">APORTACIONES</span>
                        <span class="info-box-number">
                          <div id="AptotalMC"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="ApprgrsMC"></div>
                        </div>
                        <span class="progress-description">
                          <div id="ApporcientoMC"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Proyección |Armando de Leon</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="info-box bg-aqua">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">PROYECCIÓN</span>
                        <span class="info-box-number">
                          <div id="totalADL"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="prgrsADL"></div>
                        </div>
                        <span class="progress-description">
                          <div id="porcientoADL"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">APORTACIONES</span>
                        <span class="info-box-number">
                          <div id="AptotalADL"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="ApprgrsADL"></div>
                        </div>
                        <span class="progress-description">
                          <div id="ApporcientoADL"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
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
                <h3 class="box-title">Resumen de Aportaciones | Por Comprador</h3>
              </div>
              <div class="box-body">
                <div id="resumen_aportaciones" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Resumen de Aportaciones | Comparativo</h3>
              </div>
              <div class="box-body">
                <div id="entradas_salidas" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Gastos Vs. Aportaciones | Anual</h3>
              </div>
              <div class="box-body">
                <div id="comparativo" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Resumen de Aportaciones | Por Tipo</h3>
              </div>
              <div class="box-body">
                <div id="resumen_aportaciones_tipo" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Resumen de Aportaciones | Por Proveedor</h3>
              </div>
              <div class="box-body">
                <div id="aportaciones_proveedor" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <?php include 'modal.php'; ?>
    <!-- /.content-wrapper -->
    <?php include '../footer2.php'; ?>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>
  <?php include '../footer.php'; ?>

  <!-- Page script -->
  <script>
    $('#lista_conceptos').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });
    $("#btn-consulta").click(function() {
      proyeccion(8, 'AR');
      proyeccion(34, 'FR');
      proyeccion(11, 'CW');
      proyeccion(7, 'GC');
      proyeccion(9, 'JR');
      proyeccion(10, 'JB');
      proyeccion(57, 'MC');
      proyeccion(155, 'ADL');
      resumen_comprador();
      entradas_salidas();
      resumen_tipo();
      aportaciones_proveedor();
    });

    function proyeccion(id_comprador, div) {
      var url = "datos_grafica_proyeccion.php";
      var anio = $("#anio").val();
      var concepto = $("#lista_conceptos").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          anio: anio,
          concepto: concepto,
          id_comprador: id_comprador
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#total" + div).html(array[0]);
          $("#porciento" + div).html(array[1] + " del total general");
          $("#Aptotal" + div).html(array[2]);
          $("#Apporciento" + div).html(array[3] + " de la proyección");
          $("#prgrs" + div).attr("style", "width: " + array[1]);
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function resumen_comprador() {
      var url = "datos_grafica.php";
      var anio = $("#anio").val();
      var concepto = $("#lista_conceptos").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          anio: anio,
          concepto: concepto
        },
        success: function(respuesta) {
          Highcharts.chart('resumen_aportaciones', {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Desglose de Aportaciones, 2020'
            },
            subtitle: {
              text: 'Registro por Comprador'
            },
            xAxis: {
              type: 'category'
            },
            yAxis: {
              title: {
                text: 'Total de aportaciones  ($)'
              }

            },
            legend: {
              enabled: false
            },
            plotOptions: {
              series: {
                borderWidth: 0,
                dataLabels: {
                  enabled: true,
                  format: '$ {point.y:,.2f}'
                }
              }
            },

            tooltip: {
              headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
              pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>$ {point.y:,.2f}</b> del total<br/>'
            },

            "series": [{
              "name": "Compradores",
              "colorByPoint": true,
              "data": JSON.parse("[" + respuesta + "]")
            }]
          });
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function entradas_salidas() {
      var url = "datos_grafica_comparativo.php";
      var anio = $("#anio").val();
      var concepto = $("#lista_conceptos").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          anio: anio,
          concepto: concepto
        },
        success: function(respuesta) {
          Highcharts.chart('entradas_salidas', {
            chart: {
              plotBackgroundColor: null,
              plotBorderWidth: 0,
              plotShadow: false
            },
            title: {
              text: 'Aportaciones<br>Comparativo<br>2020',
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
                center: ['50%', '75%'],
                size: '110%'
              }
            },
            series: [{
              type: 'pie',
              name: 'Gastos',
              innerSize: '50%',
              data: JSON.parse("[" + respuesta + "]")
            }]
          });
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function resumen_tipo() {
      var url = "datos_grafica_tipo.php";
      var anio = $("#anio").val();
      var concepto = $("#lista_conceptos").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          anio: anio,
          concepto: concepto
        },
        success: function(respuesta) {
          Highcharts.chart('resumen_aportaciones_tipo', {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Desglose de Aportaciones, 2020'
            },
            subtitle: {
              text: 'Registro por Tipo'
            },
            xAxis: {
              type: 'category'
            },
            yAxis: {
              title: {
                text: 'Total de aportaciones  ($)'
              }

            },
            legend: {
              enabled: false
            },
            plotOptions: {
              series: {
                borderWidth: 0,
                dataLabels: {
                  enabled: true,
                  format: '$ {point.y:,.2f}'
                }
              }
            },

            tooltip: {
              headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
              pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>$ {point.y:,.2f}</b> del total<br/>'
            },

            "series": [{
              "name": "Tipo Movimiento",
              "colorByPoint": true,
              "data": JSON.parse("[" + respuesta + "]")
            }]
          });
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function aportaciones_proveedor() {
      var url = "datos_grafica_proveedor.php";
      var anio = $("#anio").val();
      var concepto = $("#lista_conceptos").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          anio: anio,
          concepto: concepto
        },
        success: function(respuesta) {
          Highcharts.chart('aportaciones_proveedor', {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Desglose de Aportaciones, 2022'
            },
            subtitle: {
              text: 'Registro por Proveedor'
            },
            xAxis: {
              type: 'category'
            },
            yAxis: {
              title: {
                text: 'Total de aportaciones  ($)'
              }

            },
            legend: {
              enabled: false
            },
            plotOptions: {
              series: {
                borderWidth: 0,
                dataLabels: {
                  enabled: true,
                  format: '$ {point.y:,.2f}'
                }
              }
            },

            tooltip: {
              headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
              pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>$ {point.y:,.2f}</b> del total<br/>'
            },

            "series": [{
              "name": "Compradores",
              "colorByPoint": true,
              "data": JSON.parse("[" + respuesta + "]")
            }]
          });
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }
    Highcharts.chart('comparativo', {
      chart: {
        type: 'line'
      },
      title: {
        text: 'Gastos Vs. Aportaciones | Anual'
      },
      subtitle: {
        text: 'Gráfica de Comparacion'
      },
      xAxis: {
        categories: ['2017', '2018', '2019', '2020','2021','2022']
      },
      yAxis: {
        title: {
          text: 'Total ($)'
        }
      },
      plotOptions: {
        line: {
          dataLabels: {
            enabled: true
          },
          enableMouseTracking: false
        }
      },
      series: [{
        name: 'Aportaciones',
        data: [<?php include 'datos_grafica_comparativo_historial2.php'; ?>]
      }, {
        name: 'Gastos',
        data: [<?php include 'datos_grafica_comparativo_historial.php'; ?>]
      }]
    });
  </script>
</body>

</html>