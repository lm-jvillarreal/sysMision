<?php
// esto permite tener acceso desde otro servidor
    //header('Access-Control-Allow-Origin: *');
  // esto permite tener acceso desde otro servidor
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';

  $cadena = mysqli_query($conexion,"SELECT * FROM incidencias WHERE sucursal = '$id_sede'");

  $row_resultado  = mysqli_fetch_array($cadena);

  $array2 = array(
    $row_resultado[0],
    $row_resultado[1],
    $row_resultado[2],//accion sugerida
    $row_resultado[3],//comentario
    $row_resultado[4],//incidencia
    $row_resultado[5]
  	);

  $array = json_encode($array2);
  echo "$array";
?>