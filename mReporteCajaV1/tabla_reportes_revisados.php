<?php 
  include '../global_seguridad/verificar_sesion.php';
//   $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
  $filtro_sucursal = ($solo_sucursal=='1') ? " AND sucursales.id='$id_sede'":"";
  
  $cadena  = "SELECT reportes_cajas.id,CONCAT(cajas.nombre,' - ',sucursales.nombre),
  (SELECT CONCAT(cajas_catalogo_equipos.nombre,' - ', cajas_catalogo_equipos.descripcion) FROM cajas_catalogo_equipos WHERE cajas_catalogo_equipos.id = reportes_cajas.id_equipo),
  id_falla,comentario, status, (SELECT nombre FROM fallas_equipos WHERE fallas_equipos.id = reportes_cajas.id_falla)
                FROM reportes_cajas 
                INNER JOIN cajas ON cajas.id = reportes_cajas.id_caja
                INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal
                WHERE (status = '2' OR status = '3' OR status = '4')".$filtro_sucursal."ORDER BY reportes_cajas.id DESC";
  $consulta = mysqli_query($conexion, $cadena);

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

    $boton_liberar ="<center><button type='button' $disabled class='btn btn-$color' $funcion><i class='fa fa-$icono fa-lg' aria-hidden='true'></i></button></center>";

    $status = "<center><small class='label label-lg bg-$color2'>$texto</small></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Caja\": \"$row[1]\",
      \"Equipo\": \"$row[2]\",
      \"Fallo\": \"$falla\",
      \"Modificacion\": \"$row[4]\",
      \"Status\": \"$status\",
      \"Liberar\": \"$boton_liberar\"
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