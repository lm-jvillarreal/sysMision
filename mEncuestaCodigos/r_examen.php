<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';

  // $var1 = 'TORTILLA DE MAIZ LA MISION (KG)';
  // $var2 = 'TORTILLA DE MAIZ LA MISIN';
  // echo "Cadena 1 : ".$var1.'<br>';
  // echo "Cadena 2 : ".$var2.'<br>';


  // similar_text($var1, $var2, $porcentaje);

  // echo "Calcula los caracteres iguales, obtiene un porcentaje de similitud: ".round($porcentaje,2).'<br>';

  // $lev = levenshtein($var2, $var1);
  // echo "Número de caracteres que se tienen que sustituir, insertar o borrar para transformar Cadena 2  en Cadena 1 : ".$lev;

  $id_asignado = $_GET['id_asignado'];

  $cadena = mysqli_query($conexion,"SELECT examenes.nombre,
   CASE tipo_examen WHEN '1' THEN 'Códigos' WHEN '2' THEN 'Descripciones' WHEN '3' THEN 'Imágen' ELSE 'Mixto' END AS tipo_examen,
    examenes_asignados.empleado,tipo_examen, examenes.id
    FROM examenes_asignados
    INNER JOIN examenes ON examenes.id = examenes_asignados.id_examen
    WHERE examenes_asignados.id = '$id_asignado'");
  $row = mysqli_fetch_array($cadena);
  if($row[3] == "1"){
    $instrucciones = 'Escribe el código correcto de acuerdo a la descripción del producto.';
  }else if($row[3] == "2"){
    $instrucciones = 'Escribe a descripción correcta de acuerdo al código del producto.';
  }else if($row[3] == "3"){
    $instrucciones = 'Relaciona la fotografía con la descripción adecuada.';
  }else{
    $instrucciones = 'Mixto.';
  }
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
      <center>
        <h2>
          <?php echo $row[0].' | '. $row[1]?>    
        </h2>
        <h5><?php echo $row[2]?></h5>
      </center>
      <br>
      <div class="box box-danger" id="contenedor_categoria" <?php echo $solo_lectura; ?>>
        <div class="box-header">
          <h3 class="box-title"><b>* <?php echo $instrucciones;?></b></h3>
          <input type="hidden" name="id_examen" id="id_examen" value="<?php echo $row[4]?>">
          <input type="hidden" name="id_asignado" id="id_asignado" value="<?php echo $id_asignado?>">
        </div>
        <form method="POST" id="form_datos">
          <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div id="contenedor"></div>
                </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button type='button' class="btn btn-warning" id="verificar" disabled>Verificar Respuestas</button>
          </div>
        </form>
      </div>
    </section>
    <!-- /.content -->
  </div>
 <?php include '../footer2.php';?>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php include '../footer.php'; ?>
<script src="../plugins/bootstrap-fileinput-master/js/plugins/piexif.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/plugins/sortable.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/locales/fr.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/locales/es.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/themes/fa/theme.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/themes/explorer-fa/theme.js" type="text/javascript"></script>
<!-- Page script -->
<script>
  function cargar(){
    var id_asignado = $('#id_asignado').val();
    $.ajax({
      url: 'datos.php',
      type: "POST",
      data: {'id_asignado':id_asignado}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        $('#contenedor').html(respuesta);
        $('.combo').select2({
          placeholder: 'Seleccione una opcion',
          lenguage: 'es',
          //minimumResultsForSearch: Infinity
          ajax: { 
            url: "combo_cod_descrip.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
              var id_examen = $('#id_examen').val();
              return {
                searchTerm: params.term, // search term
                id_examen:id_examen
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
        $('.combo').change(function(){
          $(".combo").each(function(){
            var valor = $(this).val();
            if(valor == null){
              $('#verificar').attr('disabled',true);
            }else{
              $('#verificar').attr('disabled',false);
            }
          });
        });
        $('.input').change(function(){
          $(".input").each(function(){
            var valor = $(this).val();
            if(valor == ""){
              $('#verificar').attr('disabled',true);
            }else{
              $('#verificar').attr('disabled',false);
            }
          });
        });
      }
    });
  }
  cargar();

  $('#verificar').click(function(){
     $.ajax({
      url: 'revisar_examen.php',
      type: "POST",
      data: $('#form_datos').serialize(), // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        if(respuesta == "ok"){
          alertify.success("Respuestas Enviadas Correctamente");
          cargar();
        }else{
          alertify.error("Ha Ocurrido un Error");          
        }
      }
    });
    return false;
  })
</script>
</body>
</html>
