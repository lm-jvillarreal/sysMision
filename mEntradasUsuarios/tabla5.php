<?php 
  include '../global_seguridad/verificar_sesion.php';

  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];

  $consulta = mysqli_query($conexion,"SELECT nombre, COUNT(*) AS cantidad
                                      FROM comentarios_errores
  INNER JOIN me_control_errores ON me_control_errores.comentarios = comentarios_errores.id 
  WHERE comentarios_errores.activo = '1'
  AND me_control_errores.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
  GROUP BY nombre ORDER BY cantidad DESC LIMIT 3");
  $cuerpo = "";
  $numero = 1;

  $cadena_principal = mysqli_query($conexion,"SELECT nombre, COUNT(*) AS cantidad 
                        FROM comentarios_errores
                        INNER JOIN me_control_errores ON me_control_errores.comentarios = comentarios_errores.id 
                        WHERE comentarios_errores.activo = '1' 
                        AND me_control_errores.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                        GROUP BY nombre
                        ORDER BY cantidad DESC LIMIT 1");
  $row_principal = mysqli_fetch_array($cadena_principal);

  while ($row = mysqli_fetch_array($consulta)) 
  {
    // if($numero <= 3){
      $porcentaje = ($row[1] * 100) / $row_principal[1];
  ?>
    <div class="progress-group">
      <span class="progress-text"><?php echo $row[0];?></span>
      <span class="progress-number"><b><?php echo $row[1];?></b></span>
      
      <div class="progress progress-sm active">
            <div class="progress-bar progress-bar-red progress-bar-striped" role="progressbar" aria-valuenow=" <?php echo $porcentaje;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porcentaje.'%';?>">
              <span class="sr-only">20% Complete</span> 
            </div>
          </div>
      <!-- <div class="progress sm">
        <div class="progress-bar progress-bar-green" style="width: <?php echo $porcentaje;?>"></div>
      </div> -->
    </div>
  <?php
    //  }
    $porcentaje = 0;
    $numero ++;
    // $linea = $linea - 10;
  }
 ?>