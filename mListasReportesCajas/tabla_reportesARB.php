<?php 
  include '../global_seguridad/verificar_sesion.php';
  
  $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
  $cadena  = "SELECT rc.id, s.nombre, rc.id, cajas.nombre, te.nombre, fe.nombre, rc.status, rc.id_usuario , rc.id_sucursal, rc.activo FROM reportes_cajas  rc INNER JOIN cajas ON cajas.id= rc.id_caja INNER JOIN tipos_equipos te ON te.id_tipo = rc.id_equipo INNER JOIN fallas_equipos fe ON rc.id_falla = fe.id INNER JOIN sucursales s ON rc.id_sucursal= s.id
  WHERE rc.id_sucursal = '2' and rc.activo=1 and (rc.status = '1' OR rc.status = '2' )";
                
  $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
    $activo = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $falla = ($row[5] == "")?$row[4]:$row[5];

      if($row[6] == 1){
        $icono = "eye";
        $color = "warning";
        $funcion = "onclick='cambiar_estatus2($row[0])'";
      }else{
        $icono = "check-circle";
        $color = "success";
        $funcion = "";
      }

    $boton_status="<div class='input-group margin'><input type='text' class='form-control' style='width:100%' placeholder='Solución' id='comentario$numero'><div class='input-group-btn'><button type='button' class='btn btn-success' onclick='cambiar_estatus($row[0],$numero)'><i class='fa fa-check-circle fa-lg' aria-hidden='true'></i></button></div></div>";

    $boton_visto = "<button class='btn btn-$color' $funcion><i class='fa fa-$icono fa-lg' aria-hidden='true'></i></button>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Sucursal\": \"$row[1]\",
      \"Caja\": \"$row[3]\",
      \"Equipo\": \"$row[4]\",
      \"Fallo\": \"$falla\",
      \"Visto\": \"$boton_visto\",
      \"Status\": \"$boton_status\"
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
?>