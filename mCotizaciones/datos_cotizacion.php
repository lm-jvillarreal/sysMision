<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';

  $id_cotizacion = $_POST['id_cotizacion'];

  $numero = 1;
  $cadena = mysqli_query($conexion,"SELECT id, tipo, nombre_proveedor, proveedor, DATE_FORMAT(fecha_entrega,'%d-%m-%Y'), plazo_dias, descuento, garantias, ruta FROM proveedores_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion'");
  $calidad_general = "";
  $estrellas = "";
  $iva = 0;
  $cantidad_prov = mysqli_num_rows($cadena);

  while ($row = mysqli_fetch_array($cadena)) {

    $cadena_p = mysqli_query($conexion,"SELECT
    ROUND((SUM(detalle_cotizacion.costo)-(SUM(detalle_cotizacion.costo)*(proveedores_cotizacion.descuento / 100))),2),AVG(calidad)
    FROM detalle_cotizacion 
    INNER JOIN cotizaciones ON cotizaciones.id = detalle_cotizacion.id_cotizacion
    INNER JOIN proveedores_cotizacion ON proveedores_cotizacion.id = detalle_cotizacion.id_proveedor 
      WHERE cotizaciones.id = '$id_cotizacion' AND proveedores_cotizacion.id = '$row[0]'");
    $row_p = mysqli_fetch_array($cadena_p);
    $iva = $row_p[0] * .16;
    $costo = ($row_p[0] == "")?"$ 0":'$ '.round(($row_p[0] + $iva),2);

    if($row_p[1] > 8){
      $calidad_general = "Bueno";
    }else if($row_p[1] > 4 && $row_p[1] < 8){
      $calidad_general = "Regular";
    }else{
      $calidad_general = "Malo";
    }

    if($numero == 1){
      $color = "bg-red-active";
    }else if($numero == 2){
      $color = "bg-yellow-active";
    }else if($numero == 3){
      $color = "bg-blue-active";
    }else if($numero == 4){
      $color = "bg-red-active";
    }else if($numero == 4){
      $color = "bg-blue-light-active";
    }

    $cadena2 = "SELECT PR.PROC_CVEPROVEEDOR, CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE pr.PROC_CVEPROVEEDOR = '$row[3]'";
    $consulta_proveedores = oci_parse($conexion_central, $cadena2);
    oci_execute($consulta_proveedores);
    $row_proveedores=oci_fetch_row($consulta_proveedores);

    $nombre = ($row[1] == 1)?$row[2]:$row_proveedores[1];
    // $tipo =($row[7] != "")?"<button class='btn btn-default btn-sm pull-right'><i class='fa fa-glide-g fa-lg' aria-hidden='true'></i></button>":"";
    $docuemnto = ($row[8] != "")?"<a class='btn btn-default btn-sm pull-right' href='$row[8]' target='_blank'><i class='fa fa-file fa-lg' aria-hidden='true'></i></a>":"";

    $cadena_prin_e1 = mysqli_query($conexion,"SELECT plazo_dias FROM proveedores_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion' GROUP BY plazo_dias");

    $cantidad_prin_e1 = mysqli_num_rows($cadena_prin_e1);
    if($cantidad_prin_e1 != $cantidad_prov){ //2-3
      $sub1 = mysqli_query($conexion,"SELECT MIN(plazo_dias) FROM proveedores_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion'");
      $rowsub1 = mysqli_fetch_array($sub1);
      $rowsub11 = mysqli_query($conexion,"SELECT id FROM proveedores_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion' AND id = '$row[0]' AND plazo_dias = '$rowsub1[0]'");
      $existesub1 = mysqli_num_rows($rowsub11);
      if($existesub1 == 1){
        $estrellas = "<i class='fa fa-star fa-lg' aria-hidden='true' title='Plazo de Dias p/Pagar'></i>";
      }else{
        $estrellas = "<i class='fa fa-star-o fa-lg' aria-hidden='true' title='Plazo de Dias p/Pagar'></i>";
      }
    }else{
      $cadena_estrella1 = mysqli_query($conexion,"SELECT id, tipo, nombre_proveedor, proveedor, DATE_FORMAT(fecha_entrega,'%d-%m-%Y'), plazo_dias, descuento, garantias, ruta FROM proveedores_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion' ORDER BY plazo_dias DESC LIMIT 1"); 
      $row_estrella1 = mysqli_fetch_array($cadena_estrella1);
      if($row_estrella1[0] == $row[0]){
        $estrellas = "<i class='fa fa-star fa-lg' aria-hidden='true' title='Plazo de Dias p/Pagar'></i>";
      }else{
        $estrellas = "<i class='fa fa-star-o fa-lg' aria-hidden='true' title='Plazo de Dias p/Pagar'></i>";
      }
    }

    $cadena_prin_e2 = mysqli_query($conexion,"SELECT descuento FROM proveedores_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion' GROUP BY descuento");
    $cantidad_prin_e2 = mysqli_num_rows($cadena_prin_e2);
    if($cantidad_prin_e2 != $cantidad_prov){
      $sub2 = mysqli_query($conexion,"SELECT MAX(descuento) FROM proveedores_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion'");
      $rowsub2 = mysqli_fetch_array($sub2);
      $rowsub22 = mysqli_query($conexion,"SELECT id FROM proveedores_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion' AND id = '$row[0]' AND descuento = '$rowsub2[0]'");
      $existesub2 = mysqli_num_rows($rowsub22);
      if($existesub2 == 1){
        $estrellas .= "<i class='fa fa-star fa-lg' aria-hidden='true' title='Descuento'></i>";
      }else{
        $estrellas .= "<i class='fa fa-star-o fa-lg' aria-hidden='true' title='Descuento'></i>";
      }
    }else{
      $cadena_estrella2 = mysqli_query($conexion,"SELECT id, tipo, nombre_proveedor, proveedor, DATE_FORMAT(fecha_entrega,'%d-%m-%Y'), plazo_dias, descuento, garantias, ruta FROM proveedores_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion' ORDER BY descuento DESC LIMIT 1");

      $row_estrella2 = mysqli_fetch_array($cadena_estrella2);
      if($row_estrella2[0] == $row[0]){
        $estrellas .= "<i class='fa fa-star fa-lg' aria-hidden='true' title='Descuento'></i>";
      }else{
        $estrellas .= "<i class='fa fa-star-o fa-lg' aria-hidden='true' title='Descuento'></i>";
      } 
    }

    $cadena_prin_e3 = mysqli_query($conexion,"SELECT
        ROUND((SUM(detalle_cotizacion.costo)-(SUM(detalle_cotizacion.costo)*(proveedores_cotizacion.descuento / 100))),2) AS Costo,proveedores_cotizacion.id
        FROM detalle_cotizacion 
        INNER JOIN cotizaciones ON cotizaciones.id = detalle_cotizacion.id_cotizacion
        INNER JOIN proveedores_cotizacion ON proveedores_cotizacion.id = detalle_cotizacion.id_proveedor 
        WHERE cotizaciones.id = '$id_cotizacion'
        GROUP BY proveedores_cotizacion.id");
    $cantidad_prin_e3 = mysqli_num_rows($cadena_prin_e3);
    if($cantidad_prin_e3 != $cantidad_prov){
      $estrellas .= "<i class='fa fa-star fa-lg' aria-hidden='true' title='Costo'></i>";
    }else{
      $cadena_estrella3 = mysqli_query($conexion,"SELECT
        ROUND((SUM(detalle_cotizacion.costo)-(SUM(detalle_cotizacion.costo)*(proveedores_cotizacion.descuento / 100))),2) AS Costo,proveedores_cotizacion.id
        FROM detalle_cotizacion 
        INNER JOIN cotizaciones ON cotizaciones.id = detalle_cotizacion.id_cotizacion
        INNER JOIN proveedores_cotizacion ON proveedores_cotizacion.id = detalle_cotizacion.id_proveedor 
        WHERE cotizaciones.id = '$id_cotizacion'
        GROUP BY proveedores_cotizacion.id
        ORDER BY Costo ASC");
      $row_estrella3 = mysqli_fetch_array($cadena_estrella3);
      if($row_estrella3[1] == $row[0]){
        $estrellas .= "<i class='fa fa-star fa-lg' aria-hidden='true' title='Costo'></i>";
      }else{
        $estrellas .= "<i class='fa fa-star-o fa-lg' aria-hidden='true' title='Costo'></i>";
      }
    }

    $cadena_prin_e4 = mysqli_query($conexion,"SELECT
        AVG(calidad) AS Calidad,proveedores_cotizacion.id
        FROM detalle_cotizacion 
        INNER JOIN cotizaciones ON cotizaciones.id = detalle_cotizacion.id_cotizacion
        INNER JOIN proveedores_cotizacion ON proveedores_cotizacion.id = detalle_cotizacion.id_proveedor 
        WHERE cotizaciones.id = '$id_cotizacion'
        GROUP BY Calidad");
    $cantidad_prin_e4 = mysqli_num_rows($cadena_prin_e4);
    if($cantidad_prin_e4 != $cantidad_prov){
      $estrellas .= "<i class='fa fa-star fa-lg' aria-hidden='true' title='Calidad'></i>";
    }else{
      $cadena_estrella4 = mysqli_query($conexion,"SELECT
        AVG(calidad) AS Calidad,proveedores_cotizacion.id
        FROM detalle_cotizacion 
        INNER JOIN cotizaciones ON cotizaciones.id = detalle_cotizacion.id_cotizacion
        INNER JOIN proveedores_cotizacion ON proveedores_cotizacion.id = detalle_cotizacion.id_proveedor 
        WHERE cotizaciones.id = '$id_cotizacion'
        GROUP BY proveedores_cotizacion.id
        ORDER BY Calidad DESC");
      $row_estrella4 = mysqli_fetch_array($cadena_estrella4);
      if($row_estrella4[1] == $row[0]){
        $estrellas .= "<i class='fa fa-star fa-lg' aria-hidden='true' title='Calidad'></i>";
      }else{
        $estrellas .= "<i class='fa fa-star-o fa-lg' aria-hidden='true' title='Calidad'></i>";
      }
    }

    $cadena_prin_e5 = mysqli_query($conexion,"SELECT id, tipo, nombre_proveedor, proveedor, DATE_FORMAT(fecha_entrega,'%d-%m-%Y'), plazo_dias, descuento, garantias, ruta FROM proveedores_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion' GROUP BY fecha_entrega ");
    $cantidad_prin_e5 = mysqli_num_rows($cadena_prin_e5);
    if($cantidad_prin_e5 != $cantidad_prov){
      $sub3 = mysqli_query($conexion,"SELECT MIN(fecha_entrega) FROM proveedores_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion'");
      $rowsub3 = mysqli_fetch_array($sub3);
      $rowsub33 = mysqli_query($conexion,"SELECT id FROM proveedores_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion' AND id = '$row[0]' AND fecha_entrega = '$rowsub3[0]'");
      $existesub3 = mysqli_num_rows($rowsub33);
      if($existesub3 == 1){
        $estrellas .= "<i class='fa fa-star fa-lg' aria-hidden='true' title='Fecha Entrega'></i>";
      }else{
        $estrellas .= "<i class='fa fa-star-o fa-lg' aria-hidden='true' title='Fecha Entrega'></i>";
      }
    }else{
      $cadena_estrella5 = mysqli_query($conexion,"SELECT id, tipo, nombre_proveedor, proveedor, DATE_FORMAT(fecha_entrega,'%d-%m-%Y'), plazo_dias, descuento, garantias, ruta FROM proveedores_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion' ORDER BY fecha_entrega ASC LIMIT 1");
      $row_estrella5 = mysqli_fetch_array($cadena_estrella5);
      if($row_estrella5[0] == $row[0]){
        $estrellas .= "<i class='fa fa-star fa-lg' aria-hidden='true' title='Fecha Entrega'></i>";
      }else{
        $estrellas .= "<i class='fa fa-star-o fa-lg' aria-hidden='true' title='Fecha Entrega'></i>";
      }
    }

?>
<div class="col-md-4">
  <!-- Widget: user widget style 1 -->
  <div class="box box-widget widget-user">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header <?php echo $color?>">
      <h3 class="widget-user-username"><?php echo $nombre?></h3>

      <?php echo $estrellas;?>

      <button type="button" class="btn btn-default btn-sm pull-right" onclick="eliminar_proveedor(<?php echo $row[0];?>)"><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>
      <button type="button" class="btn btn-default btn-sm pull-right" onclick="editar_proveedor(<?php echo $row[0];?>)"><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>
      <button type="button" class="btn btn-default btn-sm pull-right" onclick="seleccionar_proveedor(<?php echo $row[0];?>,<?php echo $id_cotizacion;?>)"><i class='fa fa-check fa-lg' aria-hidden='true'></i></button>
      <?php echo $docuemnto;?>
    </div>
    <div class="box-footer">
      <div class="row">
        <div class="col-sm-4 border-right">
          <div class="description-block">
            <h5 class="description-header"><?php echo $costo?></h5>
            <span class="description-text">Costo</span>
          </div>
          <!-- /.description-block -->
        </div>
        <!-- /.col -->
        <div class="col-sm-4 border-right">
          <div class="description-block">
            <h5 class="description-header"><?php echo $row[4]?></h5>
            <span class="description-text">Fecha Entrega</span>
          </div>
          <!-- /.description-block -->
        </div>
        <!-- /.col -->
        <div class="col-sm-4">
          <div class="description-block">
            <h5 class="description-header"><?php echo $calidad_general;?></h5>
            <span class="description-text">Calidad</span>
          </div>
          <!-- /.description-block -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
  </div>
  <!-- /.widget-user -->
  <div class="table-responsive">
    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>Concepto</th>
          <th>Costo</th>
          <th>Calidad</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $cadena_c = mysqli_query($conexion,"SELECT id, nombre FROM conceptos_cotizacion WHERE activo = '1' AND id_cotizacion = '$id_cotizacion'");
          $numero2 = 1;
          while ($row_c = mysqli_fetch_array($cadena_c)) {

            $cadena2 = mysqli_query($conexion,"SELECT costo, calidad FROM detalle_cotizacion WHERE id_concepto = '$row_c[0]' AND id_proveedor='$row[0]'");
            $existe = mysqli_num_rows($cadena2);
            if($existe != 0){
              $row2 = mysqli_fetch_array($cadena2);
              $gasto = $row2[0];
              if($row2[1] == 10){
                $calidad = "btn-success";
                $texto = "Buena";
              }else if($row2[1] == 5){
                $calidad = "btn-warning";
                $texto = "Regular";
              }else{
                $calidad = "btn-danger";
                $texto = "Mala";
              }

            }else{
              $gasto   = "";
              $calidad = "btn-default";
              $texto   = "Calidad";
            }

            $costo = "<div class='input-group'><div class='input-group-addon'>$</div><input type='text' id='costo_".$numero.'_'.$numero2."' class='form-control' onkeyup='if(event.keyCode == 13)guardar($numero,$numero2,$id_cotizacion)' value='$gasto'></div>";
            $calidad = "<button class='btn $calidad btn_calidad' id='boton_".$numero.'_'.$numero2."'>$texto</button> <input type='hidden' name='proveedor_$numero' id='proveedor_$numero' value='$row[0]'>";
            $concepto = "$row_c[1]<input type='hidden' name='concepto_$numero2' id='concepto_$numero2' value='$row_c[0]'>";
        ?>
        <tr>
          <td><?php echo $concepto;?></td>
          <td><?php echo $costo;?></td>
          <td><?php echo $calidad;?></td>
        </tr>
        <?php
            $gasto   = "";
            $calidad = "btn-default";
            $texto   = "Calidad";
            $numero2 ++;
          }
        ?>
      </tbody>  
    </table>
  </div>
</div>

<?php
    $color = "";
    $numero ++;
    $estrellas ="";
    $iva = 0;
  }
?>
<script>
  $('.btn_calidad').click(function(){
      if($(this).hasClass('btn-default')){
        $(this).removeClass('btn-default');
        $(this).addClass('btn-success');
        $(this).html('Buena');
      }else if($(this).hasClass('btn-success')){
        $(this).removeClass('btn-success');
        $(this).addClass('btn-warning');
        $(this).html('Regular');
      }else if($(this).hasClass('btn-warning')){
        $(this).removeClass('btn-warning');
        $(this).addClass('btn-danger');
        $(this).html('Mala');
      }else{
        $(this).removeClass('btn-danger');
        $(this).addClass('btn-default');
        $(this).html('Calidad');
      }
    })
</script>