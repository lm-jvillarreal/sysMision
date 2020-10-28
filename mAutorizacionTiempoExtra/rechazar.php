<?php
include '../global_seguridad/verificar_sesion.php';
$id_registro = $_POST['id_registro'];

$cadena_verifica = "SELECT folio FROM tiempo_extra WHERE id = '$id_registroo'";

$consulta_verifica = mysqli_query($conexion, $cadena_verifica);
$row_verifica = mysqli_fetch_array($consulta_verifica);

if ($row_verifica[0]=='0') {
	$folio = '2';
}else {
	$folio = $row_verifica[0];
}
$cadena_modifica = "UPDATE tiempo_extra SET folio = '$folio' WHERE id = '$id_registroo'";
$modifica_estado = mysqli_query($conexion, $cadena_modifica);

 echo 'ok';
 ?>