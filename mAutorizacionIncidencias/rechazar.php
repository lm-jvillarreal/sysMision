<?php
include '../global_seguridad/verificar_sesion.php';
$id = $_POST['id'];

$cadena_verifica = "SELECT folio FROM incidencias WHERE id = '$id'";

$consulta_verifica = mysqli_query($conexion, $cadena_verifica);
$row_verifica = mysqli_fetch_array($consulta_verifica);

if ($row_verifica[0]=='0') {
	$folio = '2';
}else {
	
}
$cadena_modifica = "UPDATE incidencias SET folio = '$folio' WHERE id = '$id'";
$modifica_estado = mysqli_query($conexion, $cadena_modifica);

 echo ok;
 ?>