<?php 
include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");
  $prefijo = date("Y").date("m").date("d");

  $cadenaTurno="SELECT id, MAX(turno) FROM consulta WHERE prefijo = '$prefijo'";
  $turno_consulta=mysqli_query($conexion, $cadenaTurno);
  $row_turno = mysqli_fetch_array($turno_consulta);
  $turno = $row_turno[1];

  $cadenaCOnsecutivo="SELECT id, MAX(consecutivo) FROM turnos WHERE prefijo = '$prefijo'";
  $consulta=mysqli_query($conexion, $cadenaCOnsecutivo);
  $row_consecutivo = mysqli_fetch_array($consulta);
  $consecutivo = $row_consecutivo[1];

  $array = array($turno,$consecutivo);
  $array1 = json_encode($array);

  echo $array1;

 ?>