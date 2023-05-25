<?php 
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';

  $id_asignado = $_POST['id_asignado'];

  $cadena = mysqli_query($conexion,"SELECT examenes.nombre,
   CASE tipo_examen WHEN '1' THEN 'Códigos' WHEN '2' THEN 'Descripciones' ELSE 'Imágen' END AS tipo_examen,
    examenes_asignados.empleado,tipo_examen, examenes.id, examenes_asignados.estatus, examenes.id_categoria
    FROM examenes_asignados
    INNER JOIN examenes ON examenes.id = examenes_asignados.id_examen
    WHERE examenes_asignados.id = '$id_asignado'");
  $row = mysqli_fetch_array($cadena);
  if($row[5] == 1){
    $read  = "";
    $color = "default";
    $icono = "clock-o";
  }else{
    $read  = "readonly";
  }

  if($row[3] != 3){
  ?>
  <div class="table-responsive">
    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
      <tr>
        <th>#</th>
        <th>Código</th>
        <th>Descripción</th>
        <th>Calif.</th>
      </tr>
      <?php
        $cadena2 = mysqli_query($conexion, "SELECT codigo FROM detalle_examen WHERE id_examen = '$row[4]' AND activo = '1'");
        $numero = '1';
        while ($row2 = mysqli_fetch_array($cadena2)) {
          $st = oci_parse($conexion_central,"SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$row2[0]'");
          oci_execute($st);
          $row_producto = oci_fetch_row($st);

          if($row[5] == 2){
            $cadena_v = mysqli_query($conexion,"SELECT calificacion, respuesta FROM resultados_examen WHERE codigo = '$row2[0]' AND id_asignado = '$id_asignado'");
            $row_v = mysqli_fetch_array($cadena_v);

            $valor = ($row[3] == '1')?$row_v[1]:$row_v[1].' / '.$row_producto[0];
            // $valor = $row_v[1].' / '.$row_producto[0];
            if($row_v[0] == 10){
              $color = "success";
              $icono = "check-circle";
            }else if ($row_v[0] == 0){
              $color = "danger";
              $icono = "times-circle";
            }
            $descr = $row2[0].' - '.$row_producto[0];
          }else{
            $valor = "";
            $descr = $row_producto[0];
          }

          $codigo = ($row[3] == '1')?'<input type="text" name="respuesta[]" class="form-control input" placeholder="Escribe el Código" '.$read.' value="'.$valor.'">':'<input type="text" class="form-control" readonly placeholder="Escribe el Código" value="'.$row2[0].'">';

          $descripcion = ($row[3] == '1')?'<input type="text" class="form-control" readonly value="'.$descr.'" placeholder="Escribe la Descripción">':'<input type="text" style="text-transform:uppercase;" name="respuesta[]" class="form-control input" placeholder="Escribe la Descripción" '.$read.' value="'.$valor.'">';
      ?>
      <tr>
        <td width="3%">
          <b><?php echo $numero."<input type='hidden' name= 'codigo[]' value='$row2[0]'> <input type='hidden' name='id_asig' value='".$id_asignado."'>";?></b>  
        </td>
        <td width="15%">
          <?php echo $codigo;?>
        </td>
        <td>
          <?php echo $descripcion;?>
        </td>
        <td width="3%">
          <button class="btn btn-<?php echo $color;?>" type="button">
            <i class="fa fa-<?php echo $icono;?> fa-lg"></i>
          </button>
        </td>
      </tr>
    <?php
        $numero ++;
      }
    ?>
    </table>
  </div>
  <?php
    }else if($row[3] == 3){
      echo "<div class='row'>";
      $cadena2 = mysqli_query($conexion, "SELECT codigo FROM detalle_examen WHERE id_examen = '$row[4]' AND activo = '1'");
      $numero = '1';
      while ($row2 = mysqli_fetch_array($cadena2)) {
        if($row[5] == 1){ //NO
          $texto = "";
          $color = "";
          $ocultar = "";
          $descr = "";
          $descr2 = "";
          $icono = "";
          $input = "type='hidden'";
        }else{ //SI
          $ocultar = "style='display: none'";
          $st = oci_parse($conexion_central,"SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$row2[0]'");
          oci_execute($st);
          $row_producto = oci_fetch_row($st);

          $descr = $row2[0].' - '.$row_producto[0];

          $cadena_v = mysqli_query($conexion,"SELECT calificacion, respuesta FROM resultados_examen WHERE codigo = '$row2[0]' AND id_asignado = '$id_asignado'");
          $row_v = mysqli_fetch_array($cadena_v);

          $st = oci_parse($conexion_central,"SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$row_v[1]'");
          oci_execute($st);
          $row_producto2 = oci_fetch_row($st);

          $descr2 = $row_v[1].' - '.$row_producto2[0];
          if($row_v[0] == 10){
            $texto = "Correcto";
            $color = "success";
            $icono = "check";
          }else{
            $texto = "Incorrecto";
            $color = "error";
            $icono = "times";
          }
          $input = "type='text'";
        }
        

        $cadena3 = mysqli_query($conexion,"SELECT id FROM detalle_categoria_codigos WHERE codigo = '$row2[0]' AND id_categoria = '$row[6]'");
        $row3 = mysqli_fetch_array($cadena3);
        $ruta = 'images/'.$row3[0].'.png';
        $consulta = "SELECT id FROM detalle_categoria_codigos WHERE codigo = '$row2[0]' AND id_categoria = '$row[6]'";
  ?>
    <div class="col-md-3">
      <div class="form-group has-<?php echo $color;?>">
                  
        <a href="#" class="thumbnail">
          <img src="<?php echo $ruta;?>" alt="<?php echo $consulta;?>" height='150px' width='150px'>
        </a>
        <label class="control-label" for="inputSuccess"><i class="fa fa-<?php echo $icono;?>"></i> <?php echo $texto;?></label>
        
        <div <?php echo $ocultar;?>>
          <select name="respuesta[]" id="respuesta" class="form-control combo"></select>
          <input type="hidden" name="codigo[]" value="<?php echo $row2[0]?>">
          <input type='hidden' name='id_asig' value="<?php echo $id_asignado;?>">
        </div>
        
        <input <?php echo $input;?> class="form-control" id="inputSuccess" value="<?php echo $descr2;?>">
        <span class="help-block"><?php echo $descr;?></span>
      </div>
    </div>
<?php
      }
      echo "</div>";
    }
?>