<?php
include '../global_seguridad/verificar_sesion.php';
$id_registro = $_POST['id_registro'];

$cadena_verifica = "SELECT folio FROM incidencias WHERE id = '$id_registro'";

$consulta_verifica = mysqli_query($conexion, $cadena_verifica);
$row_verifica = mysqli_fetch_array($consulta_verifica);

if ($row_verifica[0]=='1') {
	$estado = '8';
}else {}
$cadena_modifica = "UPDATE incidencias SET folio= '$estado',autorizacion='$id_usuario' WHERE id = '$id_registro'";
$modifica_estado = mysqli_query($conexion, $cadena_modifica);

 echo "ok";
  ?>