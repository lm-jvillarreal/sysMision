<?php 
    include '../global_seguridad/verificar_sesion.php';
    $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
    $cadena  = "SELECT id,pendiente, DATE_FORMAT(fecha_inicial, '%d-%m-%Y'), DATE_FORMAT(fecha_final, '%d-%m-%Y'), (SELECT nombre FROM  tipo_actividad_mantenimiento WHERE tipo_actividad_mantenimiento.id = pendientes_mantenimiento.id_tipo_actividad), (SELECT CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = pendientes_mantenimiento.id_usuario) FROM pendientes_mantenimiento WHERE activo = '1'".$filtro;
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $actividad = mysqli_real_escape_string($conexion, $row[1]);
    $boton_liberar="<center><button type='button' onclick='liberar($row[0])' class='btn btn-success'><i class='fa fa-check-circle fa-lg' aria-hidden='true'></i></button></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Pendiente\": \"$row[1]\",
      \"FechaI\": \"$row[2]\",
      \"FechaF\": \"$row[3]\",
      \"TipoAct\": \"$row[4]\",
      \"UsuarioAlta\": \"$row[5]\",
      \"Liberar\": \"$boton_liberar\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $pieza = "";
    $compañero ="";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>