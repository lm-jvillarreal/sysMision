<?php
  include '../global_seguridad/verificar_sesion.php';
  $cadena  = "SELECT id_persona,(SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM personas WHERE personas.id = me_control_tiempos.id_persona) FROM me_control_tiempos WHERE activo = '1' GROUP BY id_persona";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $total  = 0;
  $numero = 1;
  $tiempo = "";
  while ($row_tiempo = mysqli_fetch_array($consulta)) 
  {
    $cadena_horas = mysqli_query($conexion,"SELECT tabla.Persona,tabla.Extra,tabla.Permiso,SEC_TO_TIME(tabla.Extra - tabla.Permiso)
                      FROM
                      (
                          SELECT
                              me_control_tiempos.id_persona AS Persona,
                              (
                                  SELECT
                                      SUM(TIME_TO_SEC(diferencia))
                                  FROM
                                      me_control_tiempos me1
                                  WHERE
                                      activo = '1'
                                  AND me1.id_persona = me_control_tiempos.id_persona
                                  AND me1.tipo = '1'
                              ) AS Extra,
                              (
                                  SELECT
                                      SUM(TIME_TO_SEC(diferencia))
                                  FROM
                                      me_control_tiempos me1
                                  WHERE
                                      activo = '1'
                                  AND me1.id_persona = me_control_tiempos.id_persona
                                  AND (me1.tipo = '2' OR me1.tipo = '3')
                              ) AS Permiso
                          FROM
                              me_control_tiempos
                              WHERE id_persona = '$row_tiempo[0]'
                          GROUP BY id_persona
                      ) AS tabla");
    $row_hora = mysqli_fetch_array($cadena_horas);

    if(strpos($row_hora[3],'-') !== false){
      $clase = "bg-red";
      $pulgar = "down";
      $tiempo = $row_hora[3];
    }else{
      $clase = "bg-green";
      $pulgar = "up";
      $tiempo = '+'.$row_hora[3];
    }
    if ($row_hora[3] == "00:00:00"){
      // echo "no valido";
      continue;
    }
?>
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box <?php echo $clase;?>">
      <span class="info-box-icon" onclick="abrir(<?php echo $row_tiempo[0]?>)"><i class="fa fa-thumbs-o-<?php echo $pulgar;?>"></i></span>
      <div class="info-box-content">
        <span class="info-box-text"><?php echo $row_tiempo[1];?></span>
        <span class="info-box-number"><?php echo $tiempo; ?></span>
        <div class="progress">
          <div class="progress-bar" style="width: 100%" id="barra_progreso"></div>
        </div>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <?php
    }
  ?>