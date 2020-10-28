<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha = date('Y-m-d');
  $hora  = date('h:i:s');

  $id = $_GET['id'];
  $cadena = mysqli_query($conexion,"SELECT nombre,folio FROM cuestionarios WHERE id = '$id'");
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
    <?php include 'menuV2.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="box box-danger">
        <div class="box-header text-center">
          <h3 class="box-title"><b><?php echo $row_cadena[0]?> (Vista Previa)</b></h3>
        </div>
        <div class="box-body">
          <form method="POST" id="form_datos">
            <?php
            $numero = 1;
            $opciones = "";
              $cadena_encuestas = mysqli_query($conexion,"SELECT id_pregunta FROM encuestas WHERE folio_cuestionario = '$row_cadena[1]'");
              while ($row_encuestas = mysqli_fetch_array($cadena_encuestas)) {
                $cadena_pregunta = mysqli_query($conexion,"SELECT pregunta,tipo_pregunta FROM preguntas WHERE id = '$row_encuestas[0]'");
                $row_pregunta = mysqli_fetch_array($cadena_pregunta);
                if ($row_pregunta[1] == "1"){
                  for ($o=10; $o >= 0 ; $o--) { 
                    $opciones .= "<option>$o</option>";
                  }
                 $tipo = "<select class='select2' id='respuesta' name='respuesta' style=\"width: 100%\">".$opciones."</select>";
                }
                else if ($row_pregunta[1] == "2"){
                 $tipo = "<select class='select2' id='respuesta' name='respuesta' style=\"width: 100%\">
                            <option value='1'>Bueno</option>
                            <option value='2'>Malo</option>
                            <option value='3'>Regular</option>
                          </select>"; 
                }
                else{
                 $tipo = "<input type='text' class='form-control'>";  
                }
            ?>
                <div class="row">
                  <div class="col-md-6">
                   <h4> <?php echo $numero.'- '.$row_pregunta[0]?></h4>
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
            <div class="box-footer text-right">
              <a class="btn btn-warning disabled" id="guardar">Guardar</a>
            </div>
          </form>
        </div>
      </div>
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Datos del Encuestado (opcional)</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>*Nombre del Encuestado</label>
                <input type="text" class="form-control" id="nombre_persona" name="nombre_persona">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>*Dirección</label>
                <input type="text" class="form-control" id="direcion" name="direcion">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>*Telefono</label>
                <input type="text" class="form-control" id="telefono" name="telefono">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>*Sexo</label>
                <select class="select2" style="width: 100%">
                  <option value="1">Masculino</option>
                  <option value="2">Mujer</option>
                </select>
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
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  });
</script>
</body>
</html>