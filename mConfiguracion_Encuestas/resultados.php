<?php
  include '../global_seguridad/verificar_sesion.php';
   /** Actual month last day **/
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
          <h3 class="box-title"><b>Resultados Encuestas</b></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <form id="form_datos">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Agrupacion</label>
                  <select name="agrupacion" id="agrupacion" class="select2" style="width: 100%" onchange="generar();">
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Sucursal</label>
                  <select name="sucursal" id="sucursal" class="select2" style="width: 100%" onchange="generar();"></select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Categoria</label>
                  <select name="categoria" id="categoria" class="select2" style="width: 100%" onchange="generar();cargar_tabla(this.value,$('#departamento').val(),$('#fecha_inicio').val(),$('#fecha_fin').val())"></select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Departamento</label>
                  <select name="departamento" id="departamento" class="select2" style="width: 100%" onchange="generar();mostrar(this.value);cargar_tabla(this.value,$('#departamento').val(),$('#fecha_inicio').val(),$('#fecha_fin').val());"></select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Preguntas</label>
                  <select name="preguntas" id="preguntas" class="select2" style="width: 100%;" onchange="cargar_tabla_pregunta(this.value,$('#sucursal').val(),$('#fecha_inicio').val(),$('#fecha_fin').val());"></select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_inicio">Fecha de inicio:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha1 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha1 ?>" readonly id="fecha_inicio" name="fecha_inicio" onchange="generar();">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_fin">Fecha de Fin:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha2 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha2 ?>" readonly id="fecha_fin" name="fecha_fin" onchange="generar();">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <!-- <a class="btn btn-warning" id="guardar" onclick="generar();">Generar Grafica</a> -->
              <a class="btn btn-danger" onclick="reiniciar();">Reiniciar</a>
            </div>    
          </form>
          <br>
          <div id="grafica" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div>
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title"><b>Lista de Respuestas</b></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista_respuestas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Comentario</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
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
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title"><b>Lista de Respuestas (Por Pregunta)</b></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla_pregunta" style="display: none;">
                <div class="table-responsive">
                  <table id="lista_respuestas_pregunta" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Pregunta</th>
                        <th>Respuesta</th>
                        <th>Comentario</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th></th>
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
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script>
  function cargar_tabla_pregunta(pregunta,sucursal,fecha_inicio,fecha_fin){
    $('#lista_respuestas_pregunta').dataTable().fnDestroy();
    $('#lista_respuestas_pregunta').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "ajax": {
        "type": "POST",
        "url": "tabla_respuesta_pregunta.php",
        "dataSrc": "",
        "data": {'pregunta':pregunta,'sucursal':sucursal,'fecha_inicio': fecha_inicio,'fecha_fin':fecha_fin}
      },
      "columns": [
        { "data": "#" },
        { "data": "Pregunta" },
        { "data": "Respuesta" },
        { "data": "Comentario" },
      ]
    });
  }
  function cargar_tabla(sucursal,categoria,fecha_inicio,fecha_fin){
    if (sucursal != "" && categoria != ""){
      $('#lista_respuestas').dataTable().fnDestroy();
      $('#lista_respuestas').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "ajax": {
          "type": "POST",
          "url": "tabla_respuestas.php",
          "dataSrc": "",
          "data": {'sucursal':sucursal,'categoria':categoria,'fecha_inicio': fecha_inicio,'fecha_fin':fecha_fin}
        },
        "columns": [
          { "data": "#" },
          { "data": "Comentario" },
        ]
      });
    }
  }
</script>
<script>
  function generar(){
    var url = "data.php"; // El script a dónde se realizará la petición.
    $.ajax({
      type: "POST",
      dataType: "json",
      url: url,
      data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
      // async: false,
      success: function(respuesta)
      {
        var agrupacion,sucursal,categoria,departamento,subtitulo,fecha_inicio,fecha_fin;
        
        agrupacion   = $('#agrupacion').val();
        sucursal     = $('#sucursal').val();
        categoria    = $('#categoria').val();
        departamento = $('#departamento').val();
        fecha_inicio = $('#fecha_inicio').val();
        fecha_fin    = $('#fecha_fin').val();

        if (agrupacion == 1){
          agrupacion = " Perecederos" + '/';
        }
        else if (agrupacion == 2){
          agrupacion = " Abarrotes" + '/';
        }
        else if (agrupacion == 3){
          agrupacion = " Ropa y Calzado" + '/';
        }
        else if (agrupacion == 4){
          agrupacion = " Variedades" + '/';
        }
        else{
          agrupacion = "Agrupaciones";
        }

          if (sucursal == 1){
            sucursal = " Diaz Ordaz" + '/';
          }
          else if (sucursal == 2){
            sucursal = " Arboledas" + '/';
          }
          else if (sucursal == 3){
            sucursal = " Villegas" + '/';
          }
          else if (sucursal == 4){
            sucursal = " Allende" + '/';
          }

            if (categoria == 1){
              categoria = " Frescura y Calidad" + '/';
            }
            else if (categoria == 2){
              categoria = " Orden y Acomodo de Mercancia" + '/';
            }
            else if (categoria == 3){
              categoria = " Atencion y Servicio al Cliente" + '/';
            }
            else if (categoria == 4){
              categoria = " Limpieza en Tiendas" + '/';
            }

              if (departamento == 1){
                departamento = " Abarrotes" + '/';
              }
              else if (departamento == 2){
                departamento = " Carniceria" + '/';
              }
              else if (departamento == 3){
                departamento = " Farmacia" + '/';
              }
              else if (departamento == 4){
                departamento = " Ferreteria" + '/';
              }
              else if (departamento == 5){
                departamento = " Frutas y Verduras" + '/';
              }
              else if (departamento == 6){
                departamento = " Panaderia" + '/';
              }
              else if (departamento == 7){
                departamento = " Perfumeria" + '/';
              }
              else if (departamento == 8){
                departamento = " Restaurante" + '/';
              }
              else if (departamento == 9){
                departamento = " Ropa y Calzado" + '/';
              }
              else if (departamento == 10){
                departamento = " Salchichoneria" + '/';
              }
              else if (departamento == 11){
                departamento = " Tortilleria" + '/';
              }
              else if (departamento == 12){
                departamento = " Cajas" + '/';
              }
              else if (departamento == 13){
                departamento = " Tienda General" + '/';
              }

        subtitulo = agrupacion + sucursal + categoria + departamento + ' (' + fecha_inicio + ' - ' + fecha_fin + ')';

        var options = {
          chart: {
            renderTo: 'grafica',
            type: 'column'
          },
        title: {
            text: 'Resultados Encuestas, 2019'
        },
        subtitle: {
            text: subtitulo
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Promedio'
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
                    format: '{point.y:,.2f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:,.2f}</b><br/>'
        },
          series: [{}]
        };
        options.series[0].data= respuesta;
        var chart = new Highcharts.Chart(options);
      }
    });
  }
</script>
<script>
  function combo_agrupaciones(){
    $.ajax({
      type: "POST",
      url: "combo_agrupaciones.php",
      success: function(response)
      { 
        $('#agrupacion').html(response).fadeIn();
      }
    });
  }
  function combo_sucursal(){
    $.ajax({
      type: "POST",
      url: "combo_sucursal.php",
      success: function(response)
      { 
        $('#sucursal').html(response).fadeIn();
      }
    });
  }
  function combo_categoria(){
    $.ajax({
      type: "POST",
      url: "combo_categoria.php",
      success: function(response)
      { 
        $('#categoria').html(response).fadeIn();
      }
    });
  }
  function combo_departamentos(){
    $.ajax({
      type: "POST",
      url: "combo_departamento.php",
      success: function(response)
      { 
        $('#departamento').html(response).fadeIn();
      }
    });
  }

  function reiniciar(){
    $('#agrupacion').val("");
    $('#sucursal').val("");
    $('#categoria').val("");
    $('#departamento').val("");
    cargar(0);
    
    $('#tabla').hide();
    $('#tabla_pregunta').hide();

    $('#lista_respuestas').dataTable().fnDestroy();
    $('#lista_respuestas_pregunta').dataTable().fnDestroy();

    iniciar();
  }
  function iniciar(){
    combo_categoria();
    combo_agrupaciones();
    combo_sucursal();
    combo_departamentos();
    generar();
  }
  iniciar();
  function cargar(valor){
    $('#tabla').show();
    $('#tabla_pregunta').show();
    $.ajax({
      url: "combo_pregunta.php",
      data: '&valor='+ valor,
      type: "POST",
      success: function(response)
      { 
        $('#preguntas').html(response).fadeIn();
      }
    });
  }
  function mostrar(valor){
    cargar(valor);
  }
</script>
<script>
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  });
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