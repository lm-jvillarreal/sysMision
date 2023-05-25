<?php 
  include '../global_seguridad/verificar_sesion.php';
//   $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
  $filtro_sucursal = ($solo_sucursal=='1') ? " AND sucursales.id='$id_sede'":"";
  
  $cadena  = "SELECT reportes_cajas.id,cajas.nombre,reportes_cajas.id_sucursal,
  (SELECT tipos_equipos.nombre FROM tipos_equipos WHERE tipos_equipos.id_tipo = reportes_cajas.id_equipo), comentario, status, (SELECT nombre FROM fallas_equipos WHERE fallas_equipos.id = reportes_cajas.id_falla)
                FROM reportes_cajas 
                INNER JOIN cajas ON cajas.id = reportes_cajas.id_caja
                INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal
                WHERE reportes_cajas.id_sucursal='$id_sede' AND(status = '2' OR status = '3' OR status = '4') ORDER BY reportes_cajas.id DESC";
  $consulta = mysqli_query($conexion, $cadena);
  //echo $cadena;
  $cuerpo = "";
  $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
   
    $falla = ($row[6] == "")?$row[3]:$row[6];
    $color2 = ($row[5] == 2)?"yellow":"green"; 
    $texto = ($row[5] == 2)?"Revisado":"Reparado";
    $disabled = ($row[5] == 2)?"disabled":"";
    $icono = ($row[5] == 3)?"exclamation-circle":"check-circle";
    $color = ($row[5] == 3)?"warning":"success";
    $funcion = ($row[5] == 3)?"onclick='liberar($row[0])'":"";

    // $boton_liberar ="<center><button type='button' $disabled class='btn btn-$color' $funcion><i class='fa fa-$icono fa-lg' aria-hidden='true'></i></button></center>";

    $status = "<center><small class='label label-lg bg-$color2'>$texto</small></center>";

    // array_push($datos, array(
    //   '#'=>$numero,
    //   'Caja'=>$row[1],
    //   'Equipo'=>$row[3],
    //   'Fallo'=>$falla,
    //   'Modificacion'=>$row[4],
    //   'Status'=>$status
    // ));
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Caja\": \"$row[1]\",
      \"Equipo\": \"$row[3]\",
      \"Fallo\": \"$falla\",
      \"Modificacion\": \"$row[4]\",
      \"Status\": \"$status\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
  //echo utf8_encode(json_encode($datos));
?>