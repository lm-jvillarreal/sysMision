<?php
  include '../global_seguridad/verificar_sesion.php';

  $fecha1   = $_POST['fecha1'];
  $fecha2   = $_POST['fecha2'];
  $sucursal = $_POST['sucursal'];
  if($fecha1 != $fecha2){
    return false;
  }

  $cadena = mysqli_query($conexion,"SELECT agenda_promotores.id_promotor,CONCAT(nombre, ' ',ap_paterno),compañia, hora_inicio, hora_fin FROM agenda_promotores INNER JOIN promotores ON promotores.id = agenda_promotores.id_promotor WHERE dia = '$fecha1' AND agenda_promotores.activo = '1' AND agenda_promotores.id_sucursal = '$sucursal'");

  while ($row = mysqli_fetch_array($cadena)) {
    $verificar = mysqli_query($conexion,"SELECT id FROM registro_entrada WHERE id_promotor= '$row[0]' AND fecha = '$fecha1' AND id_sucursal = '$sucursal'");
    $existe    = mysqli_num_rows($verificar);
    if($existe != 0){
      continue;
    }else{
      $ruta      = "logos/".$row[0].'.jpg';
      if(file_exists($ruta)){
        $ruta = "logos/".$row[0].'.jpg';
      }else{
        $ruta = "logos/logo.png";
      }
?>
<div class="col-md-4">
  <!-- Widget: user widget style 1 -->
  <div class="box box-widget widget-user">
    <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header bg-green-active">
    <h4 class="widget-user-username"><?php echo $row[1];?></h4>
    <h5 class="widget-user-desc"><?php echo $row[2];?></h5>
  </div>
  <div class="widget-user-image">
    <img class="img-circle" src="<?php echo $ruta;?>" alt="User Avatar">
  </div>
    <div class="box-footer">
      <div class="row">
        <div class="col-sm-4 border-right">
          <div class="description-block">
            <h5 class="description-header">No se Presentó</h5>
          </div>
          <!-- /.description-block -->
        </div>
        <div class="col-sm-8 border-right">
          <div class="description-block">
            <h5 class="description-header"><?php echo'Horario: '.substr($row[3], 0,5).' - '. substr($row[4],0,5);?></h5>
          </div>
          <!-- /.description-block -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
  </div>
  <!-- /.widget-user -->
</div>
<?php
    }
  }
?>