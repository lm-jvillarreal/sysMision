<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha = date('Y-m-d');
  $hora  = date('h:i:s');

  $id          = $_GET['id'];
  $id_sucursal = $_GET['id_sucursal'];

  $cadena = mysqli_query($conexion,"SELECT nombre FROM cuestionarios WHERE folio = '$id'");
  $row_cadena = mysqli_fetch_array($cadena);
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
        <div class="box-header text-center">
          <h3 class="box-title"><b><?php echo $row_cadena[0]?></b></h3>
        </div>
        <div class="box-body">
          <form method="POST" id="form_datos">
            <input type="number" name="id" id="id" value="<?php echo $id?>" class='hidden'>
            <input type="number" name="id_sucursal" id="id_sucursal" value="<?php echo $id_sucursal?>" class='hidden'>
            <input type="text" name="audio" id="audio" class="hidden">
            <?php
              $numero = 1;
              $opciones = "";
              $cadena_encuestas = mysqli_query($conexion,"SELECT id_pregunta FROM encuestas WHERE folio_cuestionario = '$id' AND activo = '1'");
              while ($row_encuestas = mysqli_fetch_array($cadena_encuestas)) {
                $cadena_pregunta = mysqli_query($conexion,"SELECT pregunta,tipo_pregunta FROM preguntas WHERE id = '$row_encuestas[0]'");
                $row_pregunta = mysqli_fetch_array($cadena_pregunta);
                if ($row_pregunta[1] == "1"){
                  for ($o=10; $o >= 0 ; $o--) { 
                    $opciones .= "<option>$o</option>";
                  }
                 $tipo = "<select class='select2' id='respuesta' name='respuesta[]' style=\"width: 100%\">".$opciones."</select>";
                }
                else if ($row_pregunta[1] == "2"){
                 $tipo = "<select class='select2' id='respuesta' name='respuesta[]' style=\"width: 100%\">
                            <option value='10'>Bueno</option>
                            <option value='0'>Malo</option>
                            <option value='5'>Regular</option>
                          </select>"; 
                }
                else if ($row_pregunta[1] == "3"){
                 $tipo = "<input type='text' class='form-control' name='respuesta[]' id='respuesta_texto'>";  
                }
                else if ($row_pregunta[1] == '4'){
                  $tipo = "<select class='select2' id='respuesta' name='respuesta[]' style=\"width: 100%\">
                            <option value='10'>SI</option>
                            <option value='0'>NO</option>
                          </select>";
                }
                else if ($row_pregunta[1] == '5'){
                  $tipo = "<select class='select2' id='respuesta' name='respuesta[]' style=\"width: 100%\">
                            <option value='10'>Barato</option>
                            <option value='5'>Justo</option>
                            <option value='0'>Caro</option>
                          </select>";
                }
            ?>
                <div class="row">
                  <div class="col-md-6">
                   <h4 ondblclick='abrir(<?php echo $numero?>)'> <?php echo $numero.'- '.$row_pregunta[0]?></h4>
                   <input type="number" name="pregunta[]" id="pregunta" value="<?php echo $row_encuestas[0]?>" class='hidden'>
                   <input type="text" name="comentario_pregunta[]" id='comentario_pregunta<?php echo $numero?>' class='form-control hidden' placeholder="Comentario de Pregunta">
                  </div>
                  <div class="col-md-6">
                    <?php echo $tipo?>
                  </div>
                </div>
                <br>
            <?php
              $numero ++;
              }
            ?>
          </form>
        </div>
      </div>
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Datos del Encuestado (Opcional).</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>*Nombre del Encuestado</label>
                <input type="text" class="form-control" id="nombre_persona" name="nombre_persona" form="form_datos" onblur="activar()">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>*Dirección</label>
                <input type="text" class="form-control" id="direcion" name="direccion" form="form_datos">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>*Telefono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" form="form_datos">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>*Sexo</label>
                <select class="select2" style="width: 100%" form="form_datos" id="sexo" name="sexo">
                  <option value="1">Masculino</option>
                  <option value="2">Mujer</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>*Comentarios</label>
              <input type="text" class="form-control" name="comentarios" form="form_datos">
            </div>
            <div class="col-md-6">
              <label>*Encargado del Departamento</label>
              <input type="text" class="form-control" name="encargado" form="form_datos">
            </div>
          </div>
          <br>
          <div class="row">
            <form action="upload.php" method="post" enctype="multipart/form-data">
              <div class="col-md-3">
                <label>*Grabar Audio</label>
                <input type="file" name="archivo[]" accept="audio/*" capture="microphone" id="recorder" required>
                <audio id="player" controls></audio>
                <div class="progress">
                  <div class="bar"></div >
                  <div class="percent">0%</div >
                </div>
                <div id="status"></div>
              </div>
              <div class="col-md-3">
                <br>
                <br>
                <br>
                <input type="submit" class="btn btn-success" value="Guardar Audio" id="boton_audio" style="display: none">
              </div>
            </form>
            <form action="upload_foto.php" method="post" enctype="multipart/form-data">
              <div class="col-md-3">
                <label>*Tomar Foto</label>
                <input type="file" name="archivo[]" accept="image/*" capture="environment" required>
              </div>
              <div class="col-md-3">
                <br>
                <br>
                <br>
                <input type="submit" class="btn btn-success" id="boton_foto" value="Guardar Foto" style="display: none">
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
              <a onclick="guardar();" class="btn btn-warning" id="guardar">Guardar</a>
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
<script src="jquery.form.js"></script>
<script>
(function() 
{
  var bar     = $('.bar');
  var percent = $('.percent');
  var status  = $('#status');
     
  $('form').ajaxForm({
    beforeSend: function() {
      status.empty();
      var percentVal = '0%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
      var percentVal = percentComplete + '%';
      bar.width(percentVal)
      percent.html(percentVal);
      //console.log(percentVal, position, total);
    },
    success: function() {
      var percentVal = '100%';
      // bar.width(percentVal)
      // percent.html(percentVal);
      var percentVal = '0%';
      alertify.success("Archivo Multimedia Guardado");
      $('#audio').val('1');
    },
    complete: function(xhr) {
      status.html(xhr.responseText);
    }
  }); 
})();       
</script>
<script>
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  });
</script>
<script>
  var recorder = document.getElementById('recorder');
  var player = document.getElementById('player');

  recorder.addEventListener('change', function(e) {
    var file = e.target.files[0];
    // Do something with the audio file.
    player.src =  URL.createObjectURL(file);
  });
</script>
<script>
  function guardar(){
    var url = "insertar_encuesta.php"; // El script a dónde se realizará la petición.
    $.ajax({
      type: "POST",
      url: url,
      data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        if (respuesta == "ok"){
          $(":text").val(''); //Limpiar los campos tipo Text
          $('#recorder').val('');
          $('#boton_audio').hide();
          $('#boton_foto').hide();
          swal("Resultados Guardados.", {
                icon: "success",
              });
          // alertify.success("Resultados Guardados",2);
          // location.reload();

        }
        else if(respuesta == "vacio"){
          alertify.error("Verifica Campos",2);
        }
      }
    });
  }
  function activar(){
    $('#boton_audio').show();
    $('#boton_foto').show();
  }
  function abrir(numero){
    if ($('#comentario_pregunta'+numero).hasClass('hidden')){
      $('#comentario_pregunta'+numero).removeClass('hidden');  
    }
    else{
      $('#comentario_pregunta'+numero).addClass('hidden');
    }
  }

</script>
</body>
</html>