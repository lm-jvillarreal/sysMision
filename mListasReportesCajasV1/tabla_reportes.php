<?php 
  include '../global_seguridad/verificar_sesion.php';
  
  $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
  $cadena  = "SELECT reportes_cajas.id, sucursales.nombre, cajas.nombre,
  ( SELECT nombre FROM tipos_equipos WHERE reportes_cajas.id_equipo = tipos_equipos.id_tipo ),
  id_falla, fallas_equipos.nombre, STATUS 
  FROM reportes_cajas 
  INNER JOIN cajas ON cajas.id = reportes_cajas.id_caja
  INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal
  LEFT JOIN fallas_equipos ON fallas_equipos.id = reportes_cajas.id_falla
  WHERE reportes_cajas.activo = '1' AND (reportes_cajas.status = '1' OR reportes_cajas.status = '2')";
                // .$filtro_sucursal;
  // echo $cadena;                
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
      \"Caja\": \"$row[2]\",
      \"Equipo\": \"$row[3]\",
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