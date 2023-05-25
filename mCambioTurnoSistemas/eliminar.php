<?php
include '../global_seguridad/verificar_sesion.php';
$id_registro= $_POST['registro'];

$cadena_verifica = "SELECT estatus FROM cambio_turnoSistemas WHERE id = '$id_registro'";

$consulta_verifica = mysqli_query($conexion, $cadena_verifica);
$row_verifica = mysqli_fetch_array($consulta_verifica);

if ($row_verifica[0]=='0') {
	$estado = '2';//estado 2 = cancelado
}else {}
$cadena_modifica = "UPDATE cambio_turnoSistemas SET estatus= '$estado', autoriza = '$id_usuario' WHERE id = '$id_registro'";
$modifica_estado = mysqli_query($conexion, $cadena_modifica);

//  //Consulta de datos
 $consulta_remision = mysqli_query($conexion,"SELECT empleado FROM cambio_turnoSistemas WHERE id ='$id'");
 $row = mysqli_fetch_array($consulta_remision);
 $title = "Cambio Turno: -".$row[0].'-'.$fecha;
 $consutla_calendario ="SELECT folio FROM agenda WHERE title LIKE '%$title%'";
 $cadena_calendario = mysqli_query($conexion,$consutla_calendario);
 $row2 = mysqli_fetch_array($cadena_calendario);
 $eliminar_evento = mysqli_query($conexion,"DELETE FROM agenda WHERE folio = '$row2[0]'");

 echo "ok";
  ?>