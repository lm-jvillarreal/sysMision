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
  <!-- <link rel="stylesheet" type="text/css" href="estilo_imagen.css"> -->
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
          <h3 class="box-title">Resultados</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-4">
                <label>*Selecccione una Encuesta</label>
                <select id="encuestas" name="encuestas" style="width: 100%"></select>
              </div>
              <!-- <div class="col-md-3">
                <label>*Selecccione una Pregunta</label>
                <select id="preguntas" name="preguntas" style="width: 100%"></select>
              </div> -->
              <div class="col-md-4">
                <!-- <div class="form-group">
                    <label>Rango 1</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="rango1">
                    </div>
                </div> -->
                <div class="form-group">
                  <label for="fecha1">*Fecha de inicio:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha1" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha1" name="fecha1">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha2">*Fecha Final:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha2" name="fecha2">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <!-- <div class="form-group">
                    <label>Rango 2</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="rango2">
                    </div>
                </div> -->
                <input type="hidden" name="filtro" id="filtro" value="0">
                <input type="hidden" name="filtro1" id="filtro1" value="0">
                <input type="hidden" name="filtro2" id="filtro2" value="0">
                <input type="hidden" name="sucur" id="sucur" value="">
                <input type="hidden" name="dept" id="dept" value="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="pull-right">
                <button class="btn btn-warning" onclick="regresar()">Regresar</button>
                <button class="btn btn-danger" onclick="mostrar_suc()">Generar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" id="libre">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Resultados</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <!-- <div class="col-md-2">
                  <div id="div_sucursal" style="display: none">
                    <label for="">*Sucursal</label>
                    <select name="sucursal" id="sucursal" class="form-control" onchange="mostrar_depto()" style="width: 180px"></select>
                  </div>
                  <br>
                  <div id="div_depto" style="display: none">
                    <label for="">*Departamento</label>
                    <select name="depto" id="depto" class="form-control" onchange="mostrar_tra()" style="width: 180px"></select>
                  </div>
                  <br>
                  <div id="div_tra" style="display: none">
                    <label for="">*Trabajador</label>
                    <select name="id_trabajador" id="id_trabajador" class="form-control" onchange="resultados()" style="width: 180px"></select>
                  </div>
                  <br>
                  <button class="btn btn-danger btn-sm" onclick="limpiar_d()"><i class='fa fa-undo fa-sm'></i></button>
                </div> -->
                <div class="col-md-12" id="tabla">
                  
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
 <?php include 'modal2.php'?>
  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php include '../footer.php'; ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  function cambiar(dato,dato2){

    var filtro  = $('#filtro').val();
    var filtro1 = $('#filtro1').val();

    var dept  = $('#dept').val();
    var sucur = $('#sucur').val();

    if(dept == "" && sucur == ""){
      $('#sucur').val(dato2);
    }else if(sucur != "" && dept == ""){
      $('#dept').val(dato2);
    }

    if(filtro == "0"){
      $('#filtro').val(dato);
    }else if(filtro != "0" && filtro1 == "0"){
      $('#filtro1').val(dato);
    }else{
      $('#filtro2').val(dato);
    }

    resultados();
  }
  function limpiar_d(){
    $("#sucursal").select2("trigger", "select", {
      data: { id: '', text:'' }
    });
    $("#depto").select2("trigger", "select", {
      data: { id: '', text:'' }
    });
    $("#id_trabajador").select2("trigger", "select", {
      data: { id: '', text:'' }
    });
    $('#div_depto').hide();
    $('#div_tra').hide();
  }
  function mostrar_suc(){
    resultados();
    $('#div_sucursal').show();
  }
  function mostrar_depto(){
    resultados();
    $('#div_depto').show();
  }
  function mostrar_tra(){
    resultados();
    $('#div_tra').show();
  }
  function resultados(){
    var encuesta = $('#encuestas').val();
    var filtro   = $('#filtro').val();
    var filtro1  = $('#filtro1').val();
    var filtro2  = $('#filtro2').val();
    var fecha1   = $('#fecha1').val();
    var fecha2   = $('#fecha2').val();
    var sucur    = $('#sucur').val();
    var dept     = $('#dept').val();
    // var id_trabajador = $('#id_trabajador').val();

    if (encuesta != null){
      $.ajax({
        type: "POST",
        url: "http://200.1.1.197/SMPruebas/mConfiguracion_Encuestas/resultado_porcentaje.php",
        data: {'encuesta':encuesta,'fecha1':fecha1,'fecha2':fecha2,'filtro':filtro,'filtro1':filtro1,'filtro2':filtro2,'sucur':sucur,'dept':dept}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          $('#tabla').html(respuesta);
        }
      });
    }else{
      alertify.error("Verifica Campos");
    }
  }
  $(function () {
      $('#encuestas').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
         url: "combos_encuestas.php",
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
      });
    });
   
  function ocultar(){
    $('#cualitativos').hide();
    $('#cuantitativos').hide();
    $('#cuantitativos2').hide();
    $('#libre').hide();
  }
  function resultado(){
    var fecha1      = $('#fecha1').val();
    var fecha2      = $('#fecha2').val();
    var id_encuesta = $('#encuestas').val();
    var pregunta    = $('#preguntas').val();
    pregunta = (pregunta == null)?"":pregunta;

    if(pregunta != ""){
      $.ajax({
        type: "POST",
        dataType: "html",
        url: 'verificar_pregunta.php',
        data: {'pregunta':pregunta}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          ocultar();
          if(respuesta == "1"){ //Cualitativo
            varias_graficas(id_encuesta,fecha1,fecha2);
            $('#cualitativos').show();
          }else if(respuesta == "2"){ //Cuantitativo
            generar(id_encuesta,fecha1,fecha2);
            generar_promedio(id_encuesta,fecha1,fecha2);
            generar2(id_encuesta,fecha1,fecha2);
            $('#cuantitativos').show();
            $('#cuantitativos2').show();
          }else{ //libre
            cargar_tabla_respuestas(id_encuesta,fecha1,fecha2);
            $('#libre').show();
          }
        }
      });
    }else{
      ocultar();
      generar(id_encuesta,fecha1,fecha2);
      varias_graficas(id_encuesta,fecha1,fecha2);
      generar_promedio(id_encuesta,fecha1,fecha2);
      cargar_tabla_respuestas(id_encuesta,fecha1,fecha2);
      $('#cualitativos').show();
      $('#cuantitativos').show();
      $('#libre').show();
    }
  }
  function regresar(){
    var filtro   = $('#filtro').val();
    var filtro1  = $('#filtro1').val();
    var filtro2  = $('#filtro2').val();

    if(filtro != "0" && filtro1 == "0"){
      $('#filtro').val("0");
    }else if(filtro != "0" && filtro1 != "0" && filtro2 == "0"){
      $('#filtro1').val("0");
    }else if(filtro != "0" && filtro1 != "0" && filtro2 != "0"){
      $('#filtro2').val("0");
    }
    resultados();

    var surc  = $('#surc').val();
    var dept  = $('#dept').val();

    if(sucur != "" && dept != ""){
      $('#dept').val("");
    }else if(sucur != "" && dept == ""){
      $('#sucur').val("");
    }
  }
</script>
<script type="text/javascript">
  $('.form_datetime').datetimepicker({
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
  // $('#rango1').daterangepicker();
  // $('#rango2').daterangepicker();
</script>
</body>
</html>
