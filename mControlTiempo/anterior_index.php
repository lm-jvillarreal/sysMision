<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha=date('Y-m-d');
  $hora=date('h:i:s');
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
            <h3 class="box-title">Captura de Tiempos</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
            <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="nombre_usuario">*Usuario:</label>
                    <select name="nombre_usuario" id="nombre_usuario" class="select2" style="width: 250px"></select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_inicio">*Fecha de inicio:</label>
                    <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_inicio" name="fecha_inicio">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="hora_inicio">*Hora Inicio:</label>
                    <input type="time" name="hora_inicio" class="form-control" id="hora_inicio"> 
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="hora_final">*Hora Final:</label>
                    <input type="time" name="hora_final" class="form-control" id="hora_final"> 
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="tipo_registro">*Tipo Registro:</label>
                    <select name="tipo_registro" id="tipo_registro" class="select2" style="width: 100px">
                      <option value="1">Extra</option>
                      <option value="2">Permiso</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tipo_registro">*Comentarios:</label>
                    <textarea id="comentario" class="form-control" name="comentario"></textarea>
                  </div>
                </div>
              </div>
            <div class="box-footer text-right">
              <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
            </div>
            </form>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Registros Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_tiempo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Usuario</th>
                        <th>Diferencia</th>
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
        <div id="datos_usuarios">
          <div class="box box-danger">
            <div class="box-header">
              <b><div id="nombre"></div></b>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12" id="tabla">
                  <div class="table-responsive">
                    <table id="lista_datos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th width="5%">#</th>
                          <th>Fecha</th>
                          <th>Hora Inicio</th>
                          <th>Hora Final</th>
                          <th>Tipo</th>
                          <th>Diferencia</th>
                          <th>Comentario</th>
                          <th>Comentario Pagar</th>
                          <th>Pagar</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
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
<script>
  $('#datos_usuarios').hide();
  function pagar(id){
    var comentario = $('#'+id).val();
    if (comentario == ""){
      alertify.error("Añadir Comentario");
    }
    else{
      $.ajax({
        data: {
            'id': id,
            'comentario':comentario
        }, //datos que se envian a traves de ajax
        url: 'pagar.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) 
        {
          cargar_tabla();
          $('#datos_usuarios').hide();
        }
      });
    }
  }
</script>
<script>
function cargar_tabla_datos(dato) {
  $('#lista_datos').dataTable().fnDestroy();
  $('#lista_datos').DataTable( {
    'language': {"url": "../plugins/DataTables/Spanish.json"},
    "ajax": {
        "type": "POST",
        "url": "tabla_datos.php",
        "dataSrc": "",
        "data":{'dato':dato}
    },
    "columns": [
        { "data": "#" },
        { "data": "Fecha" },
        { "data": "HoraI" },
        { "data": "HoraF" },
        { "data": "Tipo" },
        { "data": "Diferencia" },
        { "data": "Comentario" },
        { "data": "ComentarioPagar" },
        { "data": "Boton" },
    ]
 });
}
function llenar_combo_usuarios() {
  $.ajax({
    type: "POST",
    url: "combo_usuarios.php",
    success: function(response)
    { 
        $('#nombre_usuario').html(response).fadeIn();
    }
  });
}
function abrir(dato){
  $.ajax({
        data: {
            'dato': dato
        }, //datos que se envian a traves de ajax
        url: 'datos.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) 
          {
            $('#datos_usuarios').show();
            $('#nombre').html(response);
          }
      });
  cargar_tabla_datos(dato);
}
llenar_combo_usuarios();
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
<script>
  function cargar_tabla() {
    $('#lista_tiempo').dataTable().fnDestroy();
    $('#lista_tiempo').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "ajax": {
          "type": "POST",
          "url": "tabla_tiempo.php",
          "dataSrc": ""
      },
      "columns": [
          { "data": "#" },
          { "data": "Usuario" },
          { "data": "Diferencia" },
      ]
   });
  } 
  $(function (){
   cargar_tabla();
  })
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar_tiempo.php"; // El script a dónde se realizará la petición.
          $.ajax({
                 type: "POST",
                 url: url,
                 data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
                 success: function(respuesta)
                 {
                  if (respuesta=="ok") {
                    alertify.success("Registro guardado correctamente");
                    $("#nombre_usuario").val(''); //Limpiar los campos tipo Text
                    $("#hora_inicio").val(''); //Limpiar los campos tipo Text
                    $("#hora_final").val(''); //Limpiar los campos tipo Text
                    $("#comentario").val(''); //Limpiar los campos tipo Text
                    cargar_tabla();
                    llenar_combo_usuarios();
                    $('#datos_usuarios').hide();
                  }else if(respuesta=="duplicado"){
                    alertify.error("El registro ya existe");
                  }else {
                    alertify.error("Ha ocurrido un error");
                  }
                 }
               });
          // Evitar ejecutar el submit del formulario.
          return false;
      }
    });
    $( document ).ready( function () {
      $( "#form_datos" ).validate( {
        rules: {
          nombre_usuario: "required",
          hora_inicio: "required",
          hora_final: "required",
          tipo_registro: "required",
          comentario: "required"
        },
        messages: {
          nombre_usuario: "Campo requerido",
          hora_inicio: "Campo requerido",
          hora_final: "Campo requerido",
          tipo_registro: "Campo requerido",
          comentario: "Campo requerido"
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
          // Add the `help-block` class to the error element
          error.addClass( "help-block" );

          if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element.parent( "label" ) );
          } else {
            error.insertAfter( element );
          }
        },
        highlight: function ( element, errorClass, validClass ) {
          $( element ).parents( ".col-md-3" ).addClass( "has-error" ).removeClass( "has-success" );
          $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
          $( element ).parents( ".col-md-6" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).parents( ".col-md-3" ).addClass( "has-success" ).removeClass( "has-error" );
          $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
          $( element ).parents( ".col-md-6" ).addClass( "has-success" ).removeClass( "has-error" );
        }
      });
    });
  </script>
  <script>
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })
</script>
</body>
</html>
