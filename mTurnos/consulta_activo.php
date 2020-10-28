<?php
 include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");
  $prefijo = date("Y").date("m").date("d");


  $consulta_verifica = mysqli_query($conexion, "SELECT activo FROM turos WHERE id = '$prefijo'");
  $row_verifica = mysqli_fetch_array($consulta_verifica);

  if ($row_verifica[0]=='0') {
    $activo = '1';
  }elseif($row_verifica[0]=='1'){
    $activo = '0';
  }

  $modifica_estado = mysqli_query($conexion, "UPDATE turnos SET activo = 1 WHERE id = '$prefijo'");

  echo "ok";
 ?>