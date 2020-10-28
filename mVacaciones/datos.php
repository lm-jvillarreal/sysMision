<?php
  
  include '../global_seguridad/verificar_sesion.php';

  $filtro=(!empty($registros_propios) == '1')?" AND vacaciones.id_usuario = '$id_usuario'":"";
  
  $cadena = mysqli_query($conexion,"SELECT id_usuario,
    (SELECT CONCAT(nombre,' ',ap_paterno,' ', ap_materno) FROM personas WHERE usuarios.id_persona = personas.id),
    usados,actual
    FROM vacaciones
    INNER JOIN usuarios ON usuarios.id = vacaciones.id_usuario where vacaciones.activo='1'".$filtro);

  $campos        = "";
  $resultado     = 0;
  $resultado2    = 0;
  $cadena2       = "";
  $cantidad_dias = 0;

  while ($row = mysqli_fetch_array($cadena)){

    
    

    $cadena2 = mysqli_query($conexion,"SELECT fecha_vacaciones FROM historico_vacaciones WHERE id_usuario = '$row[0]' AND activo = '1'");

    $vaca = mysqli_num_rows($cadena2);
    $cantidad_dias = $vaca;
    $cantidad_dias = ($cantidad_dias == "")?0:$cantidad_dias;

    $resultado  = $row[3] - $cantidad_dias;
    $resultado2 = ($cantidad_dias * 100) / $row[3];

  	$campos .= "<div class='col-md-3 col-sm-6 col-xs-12'>
                  <div class='info-box bg-yellow'>
                    <span class='info-box-icon' onclick='detalles($row[0])'><i class='ion ion-person'></i></span>
                    <div class='info-box-content'>
                      <span class='info-box-text'>$row[1]</span>
                      <span class='info-box-number'>$resultado</span>
                      <div class='progress'>
                        <div class='progress-bar' style='width: $resultado2%'></div>
                      </div>
                        <span class='progress-description'>
                          $cantidad_dias dia(s) usados.
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>";

    $cantidad_dias = "";
  }
  echo $campos;
