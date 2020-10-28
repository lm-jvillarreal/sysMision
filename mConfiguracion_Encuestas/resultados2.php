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
    <?php include 'menuV3.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title"><b>Resultados Generales</b></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <center>
                    <h3 class="box-title"><b>Resultado por Sucursal</b></h3>
                  </center>
                </div>
                <div class="box-body">
                  <div class="chart">
                    <canvas id="barChart2" style="height:230px"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <center>
                    <h3 class="box-title"><b>Resultado por Categoria</b></h3>
                  </center>
                </div>
                <div class="box-body">
                  <div class="chart">
                    <canvas id="barChart1" style="height:230px"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-success">
                <div class="box-header with-border">
                  <center>
                    <h3 class="box-title"><b>Resultado por Encuesta</b></h3>
                  </center>
                </div>
                <div class="box-body">
                  <div class="chart">
                    <canvas id="barChart" style="height:230px"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title"><b>Resultados Especificos</b></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <center>
                    <h3 class="box-title"><b>Resultado Diaz Ordaz</b></h3>
                  </center>
                </div>
                <div class="box-body">
                  <div class="chart">
                    <canvas id="barChartDO" style="height:230px"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <center>
                    <h3 class="box-title"><b>Resultado Arboledas</b></h3>
                  </center>
                </div>
                <div class="box-body">
                  <div class="chart">
                    <canvas id="barChartAR" style="height:230px"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <center>
                    <h3 class="box-title"><b>Resultado Villegas</b></h3>
                  </center>
                </div>
                <div class="box-body">
                  <div class="chart">
                    <canvas id="barChartVI" style="height:230px"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <center>
                    <h3 class="box-title"><b>Resultado Allende</b></h3>
                  </center>
                </div>
                <div class="box-body">
                  <div class="chart">
                    <canvas id="barChartAL" style="height:230px"></canvas>
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
<!-- <script src="../../bower_components/Chart.js/Chart.js"></script> -->
<script src="../d_plantilla/bower_components/Chart.js/Chart.js"></script>
<script>
  function llenar_combo_sucursales() {
    $.ajax({
      type: "POST",
      url: "combo_sucursales.php",
      success: function(response)
      { 
        $('#sucursal').html(response).fadeIn();
      }
    });
  }
  llenar_combo_sucursales();
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  });
</script>
<script>
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  });
  function llenar_combo_encuestas() {
    $.ajax({
      type: "POST",
      url: "combo_encuestas.php",
      success: function(response)
      { 
        $('#encuesta').html(response).fadeIn();
      }
    });
  }
  llenar_combo_encuestas();
  function cargar_preguntas(folio){
    $.ajax({
      type: "POST",
      url: "combo_pre.php",
      data: "&folio="+folio,
      success: function(response)
      { 
        $('#preguntas').html(response).fadeIn();
      }
    });
  }
</script>
<script>
  <?php
    $cadenaALL = mysqli_query($conexion,"SELECT folio,nombre FROM cuestionarios WHERE id_sucursal = '4' AND activo = '1'");
    $cantidades = mysqli_num_rows($cadenaALL);
    $numeros         = 0;
    $numero          = 0;
    $nombre_encuesta = "";
    $datos_totales   = "";
    $total_preguntas = 0;
  ?>
  var areaChartData = {
    labels  : [
      <?php
        while ($row_cuestionarios = mysqli_fetch_array($cadenaALL)) {
          $cadenaALL2 = mysqli_query($conexion,"SELECT re.respuesta,p.tipo_pregunta FROM resultados_encuestas re INNER JOIN preguntas p ON re.id_pregunta = p.id WHERE re.id_sucursal = '4' AND re.id_cuestionario = '$row_cuestionarios[0]' AND re.activo = '1'");
        $cantidad_preguntas = mysqli_num_rows($cadenaALL2);
          while ($row_respuesta = mysqli_fetch_array($cadenaALL2)) {
              $numero += $row_respuesta[0];
          }
          if ($numero == 0){
            $promedio = 0;
          }
          else{
            $promedio = $numero / $cantidad_preguntas;
          }
          $total_preguntas += $cantidad_preguntas;

          if ($numeros == $cantidad_preguntas){
            $nombre_encuesta.= "'".$row_cuestionarios[1]."'";
            $datos_totales .= "'".round($promedio,2)."'";
          }
          else{
            $nombre_encuesta.="'".$row_cuestionarios[1]."',";
            $datos_totales .= "'".round($promedio,2)."',";
          }
          $promedio = 0;
          $numero = 0;
          $numeros ++;
        }
        echo $nombre_encuesta;
      ?>
    ],
    datasets: [
      {
        label               : 'Digital Goods',
        fillColor           : 'rgba(142,68,173,1.0)',
        strokeColor         : 'rgba(142,68,173,1.0)',
        pointColor          : '#8e44ad',
        pointStrokeColor    : 'rgba(142,68,173,1.0)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(142,68,173,1.0)',
        data                : [<?php echo $datos_totales;?>      
        ]
      }
    ]
  }
  var barChartCanvas                   = $('#barChartAL').get(0).getContext('2d')
  var barChart                         = new Chart(barChartCanvas)
  var barChartData                     = areaChartData
  barChartData.datasets[0].fillColor   = '#8e44ad'
  barChartData.datasets[0].strokeColor = '#8e44ad'
  barChartData.datasets[0].pointColor  = '#8e44ad'
  var barChartOptions                  = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero        : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - If there is a stroke on each bar
    barShowStroke           : true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth          : 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing         : 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing       : 1,
    //String - A legend template
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    //Boolean - whether to make the chart responsive
    responsive              : true,
    maintainAspectRatio     : true
  }

  barChartOptions.datasetFill = false
  barChart.Bar(barChartData, barChartOptions)
</script>
<script>
  <?php
    $cadenaVILL = mysqli_query($conexion,"SELECT folio,nombre FROM cuestionarios WHERE id_sucursal = '3' AND activo = '1'");
    $cantidades = mysqli_num_rows($cadenaVILL);
    $numeros         = 0;
    $numero          = 0;
    $nombre_encuesta = "";
    $datos_totales   = "";
    $total_preguntas = 0;
  ?>
  var areaChartData = {
    labels  : [
      <?php
        while ($row_cuestionarios = mysqli_fetch_array($cadenaVILL)) {
          $cadenaVILL2 = mysqli_query($conexion,"SELECT re.respuesta,p.tipo_pregunta FROM resultados_encuestas re INNER JOIN preguntas p ON re.id_pregunta = p.id WHERE re.id_sucursal = '3' AND re.id_cuestionario = '$row_cuestionarios[0]' AND re.activo = '1'");
        $cantidad_preguntas = mysqli_num_rows($cadenaVILL2);
          while ($row_respuesta = mysqli_fetch_array($cadenaVILL2)) {
            // if ($row_respuesta[1] == 2){
            //   if ($row_respuesta[0] == 1){
            //     $numero += 10;
            //   }
            //   else if ($row_respuesta[1] == 2){
            //     $numero += 0;
            //   }
            //   else if ($row_respuesta[1] == 3){
            //     $numero += 5;
            //   }
            // }
            // else{
              $numero += $row_respuesta[0];
//            }
          }
          if ($numero == 0){
            $promedio = 0;
          }
          else{
            $promedio = $numero / $cantidad_preguntas;
          }
          $total_preguntas += $cantidad_preguntas;

          if ($numeros == $cantidad_preguntas){
            $nombre_encuesta.= "'".$row_cuestionarios[1]."'";
            $datos_totales .= "'".round($promedio,2)."'";
          }
          else{
            $nombre_encuesta.="'".$row_cuestionarios[1]."',";
            $datos_totales .= "'".round($promedio,2)."',";
          }
          $promedio = 0;
          $numero = 0;
          $numeros ++;
        }
        echo $nombre_encuesta;
      ?>
    ],
    datasets: [
      {
        label               : 'Digital Goods',
        fillColor           : 'rgba(41,128,185,1.0)',
        strokeColor         : 'rgba(41,128,185,1.0)',
        pointColor          : '#2980b9',
        pointStrokeColor    : 'rgba(41,128,185,1.0)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(41,128,185,1.0)',
        data                : [<?php echo $datos_totales;?>      
        ]
      }
    ]
  }
  var barChartCanvas                   = $('#barChartVI').get(0).getContext('2d')
  var barChart                         = new Chart(barChartCanvas)
  var barChartData                     = areaChartData
  barChartData.datasets[0].fillColor   = '#2980b9'
  barChartData.datasets[0].strokeColor = '#2980b9'
  barChartData.datasets[0].pointColor  = '#2980b9'
  var barChartOptions                  = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero        : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - If there is a stroke on each bar
    barShowStroke           : true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth          : 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing         : 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing       : 1,
    //String - A legend template
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    //Boolean - whether to make the chart responsive
    responsive              : true,
    maintainAspectRatio     : true
  }

  barChartOptions.datasetFill = false
  barChart.Bar(barChartData, barChartOptions)
</script>
<script>
  <?php
    $cadenaAR = mysqli_query($conexion,"SELECT folio,nombre FROM cuestionarios WHERE id_sucursal = '2' AND activo = '1'");
    $cantidades = mysqli_num_rows($cadenaAR);
    $numeros         = 0;
    $numero          = 0;
    $nombre_encuesta = "";
    $datos_totales   = "";
    $total_preguntas = 0;
  ?>
  var areaChartData = {
    labels  : [
      <?php
        while ($row_cuestionarios = mysqli_fetch_array($cadenaAR)) {
          $cadenaAR2 = mysqli_query($conexion,"SELECT re.respuesta,p.tipo_pregunta FROM resultados_encuestas re INNER JOIN preguntas p ON re.id_pregunta = p.id WHERE re.id_sucursal = '2' AND re.id_cuestionario = '$row_cuestionarios[0]' AND re.activo = '1'");
        $cantidad_preguntas = mysqli_num_rows($cadenaAR2);
          while ($row_respuesta = mysqli_fetch_array($cadenaAR2)) {
            // if ($row_respuesta[1] == 2){
            //   if ($row_respuesta[0] == 1){
            //     $numero += 10;
            //   }
            //   else if ($row_respuesta[1] == 2){
            //     $numero += 0;
            //   }
            //   else if ($row_respuesta[1] == 3){
            //     $numero += 5;
            //   }
            // }
            // else{
              $numero += $row_respuesta[0];
            //}
          }
          if ($numero == 0){
            $promedio = 0;
          }
          else{
            $promedio = $numero / $cantidad_preguntas;
          }
          $total_preguntas += $cantidad_preguntas;

          if ($numeros == $cantidad_preguntas){
            $nombre_encuesta.= "'".$row_cuestionarios[1]."'";
            $datos_totales .= "'".round($promedio,2)."'";
          }
          else{
            $nombre_encuesta.="'".$row_cuestionarios[1]."',";
            $datos_totales .= "'".round($promedio,2)."',";
          }
          $promedio = 0;
          $numero = 0;
          $numeros ++;
        }
        echo $nombre_encuesta;
      ?>
    ],
    datasets: [
      {
        label               : 'Digital Goods',
        fillColor           : 'rgba(39,174,96,1.0)',
        strokeColor         : 'rgba(39,174,96,1.0)',
        pointColor          : '#27ae60',
        pointStrokeColor    : 'rgba(39,174,96,1.0)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(39,174,96,1.0)',
        data                : [<?php echo $datos_totales;?>      
        ]
      }
    ]
  }
  var barChartCanvas                   = $('#barChartAR').get(0).getContext('2d')
  var barChart                         = new Chart(barChartCanvas)
  var barChartData                     = areaChartData
  barChartData.datasets[0].fillColor   = '#27ae60'
  barChartData.datasets[0].strokeColor = '#27ae60'
  barChartData.datasets[0].pointColor  = '#27ae60'
  var barChartOptions                  = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero        : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - If there is a stroke on each bar
    barShowStroke           : true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth          : 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing         : 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing       : 1,
    //String - A legend template
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    //Boolean - whether to make the chart responsive
    responsive              : true,
    maintainAspectRatio     : true
  }

  barChartOptions.datasetFill = false
  barChart.Bar(barChartData, barChartOptions)
</script>
<script>
  <?php
    $cadenaDO = mysqli_query($conexion,"SELECT folio,nombre FROM cuestionarios WHERE id_sucursal = '1' AND activo = '1'");
    $cantidades = mysqli_num_rows($cadenaDO);
    $numeros         = 0;
    $numero          = 0;
    $nombre_encuesta = "";
    $datos_totales   = "";
    $total_preguntas = 0;
  ?>
  var areaChartData = {
    labels  : [
      <?php
        while ($row_cuestionarios = mysqli_fetch_array($cadenaDO)) {
          $cadenaDO2 = mysqli_query($conexion,"SELECT re.respuesta,p.tipo_pregunta FROM resultados_encuestas re INNER JOIN preguntas p ON re.id_pregunta = p.id WHERE re.id_sucursal = '1' AND re.id_cuestionario = '$row_cuestionarios[0]' AND re.activo = '1'");
        $cantidad_preguntas = mysqli_num_rows($cadenaDO2);
          while ($row_respuesta = mysqli_fetch_array($cadenaDO2)) {
            // if ($row_respuesta[1] == 2){
            //   if ($row_respuesta[0] == 1){
            //     $numero += 10;
            //   }
            //   else if ($row_respuesta[1] == 2){
            //     $numero += 0;
            //   }
            //   else if ($row_respuesta[1] == 3){
            //     $numero += 5;
            //   }
            // }
            // else{
              $numero += $row_respuesta[0];
            //}
          }
          if ($numero == 0){
            $promedio = 0;
          }
          else{
            $promedio = $numero / $cantidad_preguntas;
          }
          $total_preguntas += $cantidad_preguntas;

          if ($numeros == $cantidad_preguntas){
            $nombre_encuesta.= "'".$row_cuestionarios[1]."'";
            $datos_totales .= "'".round($promedio,2)."'";
          }
          else{
            $nombre_encuesta.="'".$row_cuestionarios[1]."',";
            $datos_totales .= "'".round($promedio,2)."',";
          }
          $promedio = 0;
          $numero = 0;
          $numeros ++;
        }
        echo $nombre_encuesta;
      ?>
    ],
    datasets: [
      {
        label               : 'Digital Goods',
        fillColor           : 'rgba(232,65,24,1.0)',
        strokeColor         : 'rgba(232,65,24,1.0)',
        pointColor          : '#e84118',
        pointStrokeColor    : 'rgba(232,65,24,1.0)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(232,65,24,1.0)',
        data                : [<?php echo $datos_totales;?>      
        ]
      }
    ]
  }
  var barChartCanvas                   = $('#barChartDO').get(0).getContext('2d')
  var barChart                         = new Chart(barChartCanvas)
  var barChartData                     = areaChartData
  barChartData.datasets[0].fillColor   = '#e84118'
  barChartData.datasets[0].strokeColor = '#e84118'
  barChartData.datasets[0].pointColor  = '#e84118'
  var barChartOptions                  = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero        : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - If there is a stroke on each bar
    barShowStroke           : true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth          : 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing         : 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing       : 1,
    //String - A legend template
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    //Boolean - whether to make the chart responsive
    responsive              : true,
    maintainAspectRatio     : true
  }

  barChartOptions.datasetFill = false
  barChart.Bar(barChartData, barChartOptions)
</script>
<script>
  <?php
    $cadena_cuestionarios = mysqli_query($conexion,"SELECT folio,nombre FROM cuestionarios WHERE activo = '1' GROUP BY folio");
    $cantidad_cuestionarios = mysqli_num_rows($cadena_cuestionarios);
    $numeros         = 0;
    $numero          = 0;
    $nombre_encuesta = "";
    $datos_totales   = "";
    $total_preguntas = 0;
  ?>
  var areaChartData = {
    labels  : [
      <?php
        while ($row_cuestionarios = mysqli_fetch_array($cadena_cuestionarios)) {
          $cadena_preguntas = mysqli_query($conexion,"SELECT re.respuesta,p.tipo_pregunta
                                                      FROM
                                                        resultados_encuestas re
                                                      INNER JOIN preguntas p ON re.id_pregunta = p.id
                                                      WHERE
                                                        re.id_cuestionario = '$row_cuestionarios[0]'
                                                      AND re.activo = '1'");
          $cantidad_preguntas = mysqli_num_rows($cadena_preguntas);
          while ($row_respuesta = mysqli_fetch_array($cadena_preguntas)) {
            // if ($row_respuesta[1] == 2){
            //   if ($row_respuesta[0] == 1){
            //     $numero += 10;
            //   }
            //   else if ($row_respuesta[1] == 2){
            //     $numero += 0;
            //   }
            //   else if ($row_respuesta[1] == 3){
            //     $numero += 5;
            //   }
            // }
            //else{
              $numero += $row_respuesta[0];
            //}
          }
          $total_preguntas += $cantidad_preguntas;
          if($numero == 0){
            $promedio = 0;
          }
          else{
            $promedio = $numero / $cantidad_preguntas;
          }

          if ($numeros == $cantidad_cuestionarios){
            $nombre_encuesta.= "'".$row_cuestionarios[1]."'";
            $datos_totales .= "'".round($promedio,2)."'";
          }
          else{
            $nombre_encuesta.="'".$row_cuestionarios[1]."',";
            $datos_totales .= "'".round($promedio,2)."',";
          }
          $promedio = 0;
          $numero = 0;
        }
        echo $nombre_encuesta;
      ?>
    ],
    datasets: [
      {
        label               : 'Digital Goods',
        fillColor           : 'rgba(60,141,188,0.9)',
        strokeColor         : 'rgba(60,141,188,0.8)',
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : [<?php echo $datos_totales;?>      
        ]
      }
    ]
  }
  var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
  var barChart                         = new Chart(barChartCanvas)
  var barChartData                     = areaChartData
  barChartData.datasets[0].fillColor   = '#00a65a'
  barChartData.datasets[0].strokeColor = '#00a65a'
  barChartData.datasets[0].pointColor  = '#00a65a'
  var barChartOptions                  = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero        : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - If there is a stroke on each bar
    barShowStroke           : true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth          : 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing         : 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing       : 1,
    //String - A legend template
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    //Boolean - whether to make the chart responsive
    responsive              : true,
    maintainAspectRatio     : true
  }

  barChartOptions.datasetFill = false
  barChart.Bar(barChartData, barChartOptions)
</script>
<script>
  <?php
    $cadena_categoria = mysqli_query($conexion,"SELECT id_categoria,CASE
                                                      id_categoria 
                                                      WHEN '1' THEN
                                                      'Frescura y Calidad' 
                                                      WHEN '2' THEN
                                                      'Orden y Acomodo de Mercancia'
                                                      WHEN '3' THEN
                                                      'Atencion y Servicio al Cliente'
                                                      WHEN '4' THEN
                                                      'Limpieza en Tiendas'
                                                    END AS id_categoria FROM preguntas WHERE activo = '1' GROUP BY id_categoria");
    $cantidad_categorias = mysqli_num_rows($cadena_categoria);
    $numero1 = 0;
    $promedio1 = 0;
    $total_preguntas1 = 0;
    $datos_totales1 = "";
    $nombre_categoria = "";
  ?>
  var areaChartData = {
    labels  : [
      <?php
        while ($row_categoria = mysqli_fetch_array($cadena_categoria)) {
          $cadena_preguntas1 = mysqli_query($conexion,"SELECT re.respuesta,p.tipo_pregunta
                        FROM resultados_encuestas re
                        INNER JOIN preguntas p ON re.id_pregunta = p.id
                        WHERE p.id_categoria = '$row_categoria[0]'
                        AND re.activo = '1'");
          $cantidad_preguntas1 = mysqli_num_rows($cadena_preguntas1);
          while ($row_respuesta1 = mysqli_fetch_array($cadena_preguntas1)) {
            // if ($row_respuesta1[1] == 2){
            //   if ($row_respuesta1[0] == 1){
            //     $numero1 += 10;
            //   }
            //   else if ($row_respuesta1[1] == 2){
            //     $numero1 += 0;
            //   }
            //   else if ($row_respuesta1[1] == 3){
            //     $numero1 += 5;
            //   }
            // }
            // else{
              $numero1 += $row_respuesta1[0];
            //}
          }

          $total_preguntas1 += $cantidad_preguntas1;

          if($numero1 == 0){
            $promedio1 = 0;
          }
          else{
            $promedio1 = $numero1 / $cantidad_preguntas1;
          }

          if ($numeros == $cantidad_categorias){
            $nombre_categoria.= "'".$row_categoria[1]."'";
            $datos_totales1 .= "'".round($promedio1,2)."'";
          }
          else{
            $nombre_categoria.="'".$row_categoria[1]."',";
            $datos_totales1 .= "'".round($promedio1,2)."',";
          }
          // echo $numero1.' - '.'Promedio:'.round($promedio1,2).' - '.$row_categoria[0].'<br>';
          $numero1 = 0;
          $promedio1 = 0;
        }
        echo $nombre_categoria;
      ?>
    ],
    datasets: [
      {
        label               : 'Digital Goods',
        fillColor           : 'rgba(34, 112, 147,1.0)',
        strokeColor         : 'rgba(34, 112, 147,1.0)',
        pointColor          : '#227093 ',
        pointStrokeColor    : 'rgba(34, 112, 147,1.0)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(34, 112, 147,1.0)',
        data                : [<?php echo $datos_totales1;?>      
        ]
      }
    ]
  }
  var barChartCanvas                   = $('#barChart1').get(0).getContext('2d')
  var barChart                         = new Chart(barChartCanvas)
  var barChartData                     = areaChartData
  barChartData.datasets[0].fillColor   = '#227093'
  barChartData.datasets[0].strokeColor = '#227093'
  barChartData.datasets[0].pointColor  = '#227093'
  var barChartOptions                  = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero        : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - If there is a stroke on each bar
    barShowStroke           : true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth          : 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing         : 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing       : 1,
    //String - A legend template
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    //Boolean - whether to make the chart responsive
    responsive              : true,
    maintainAspectRatio     : true
  }

  barChartOptions.datasetFill = false
  barChart.Bar(barChartData, barChartOptions)
</script>
<script>
  <?php
    $cadena_sucursal = mysqli_query($conexion,"SELECT id,nombre FROM sucursales WHERE activo = '1'");
    $cantidad_sucursal = mysqli_num_rows($cadena_sucursal);
    $numero2 = 0;
    $promedio2 = 0;
    $total_preguntas2 = 0;
    $datos_totales2 = "";
    $nombre_sucursal = "";
  ?>
  var areaChartData = {
    labels  : [
      <?php
        while ($row_sucursal = mysqli_fetch_array($cadena_sucursal)) {
          $cadena_preguntas2 = mysqli_query($conexion,"SELECT
                                  re.respuesta,
                                  p.tipo_pregunta
                                FROM
                                  resultados_encuestas re
                                INNER JOIN preguntas p ON re.id_pregunta = p.id
                                WHERE
                                  re.id_sucursal = '$row_sucursal[0]'
                                AND re.activo = '1'");
          $cantidad_preguntas2 = mysqli_num_rows($cadena_preguntas2);
          while ($row_respuesta2 = mysqli_fetch_array($cadena_preguntas2)) {
            // if ($row_respuesta2[1] == 2){
            //   if ($row_respuesta2[0] == 1){
            //     $numero2 += 10;
            //   }
            //   else if ($row_respuesta2[1] == 2){
            //     $numero2 += 0;
            //   }
            //   else if ($row_respuesta2[1] == 3){
            //     $numero2 += 5;
            //   }
            // }
            // else{
              $numero2 += $row_respuesta2[0];
            //}
          }
          if ($numero2 != 0){
            $promedio2 = $numero2 / $cantidad_preguntas2; 
          }
          else{
            $promedio2 = 0;
          }

          if ($numeros == $cantidad_categorias){
            $nombre_sucursal.= "'".$row_sucursal[1]."'";
            $datos_totales2 .= "'".round($promedio2,2)."'";
          }
          else{
            $nombre_sucursal.="'".$row_sucursal[1]."',";
            $datos_totales2 .= "'".round($promedio2,2)."',";
          }
          $total_preguntas2 += $cantidad_preguntas2;
          $numero2 = 0;
          $promedio2 = 0;
        }
        echo $nombre_sucursal;
      ?>
    ],
    datasets: [
      {
        label               : 'Digital Goods',
        fillColor           : 'rgba(205, 97, 51,1.0)',
        strokeColor         : 'rgba(205, 97, 51,1.0)',
        pointColor          : '#cd6133',
        pointStrokeColor    : 'rgba(205, 97, 51,1.0)',
        pointHighlightFill  : '#cd6133',
        pointHighlightStroke: 'rgba(205, 97, 51,1.0)',
        data                : [<?php echo $datos_totales2;?>      
        ]
      }
    ]
  }
  var barChartCanvas                   = $('#barChart2').get(0).getContext('2d')
  var barChart                         = new Chart(barChartCanvas)
  var barChartData                     = areaChartData
  barChartData.datasets[0].fillColor   = '#cd6133'
  barChartData.datasets[0].strokeColor = '#cd6133'
  barChartData.datasets[0].pointColor  = '#cd6133'
  var barChartOptions                  = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero        : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - If there is a stroke on each bar
    barShowStroke           : true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth          : 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing         : 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing       : 1,
    //String - A legend template
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    //Boolean - whether to make the chart responsive
    responsive              : true,
    maintainAspectRatio     : true
  }

  barChartOptions.datasetFill = false
  barChart.Bar(barChartData, barChartOptions)
</script>
</body>
</html>