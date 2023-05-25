<?php
include '../global_seguridad/verificar_sesion.php';
$id_articulo = $_POST['id_articulo'];
$subreceta = $_POST['subreceta'];

$cadena_verifica = "SELECT ACTIVO FROM tortilleria_subrecetasrenglones WHERE ID_ARTICULO = '$id_articulo'";
$consulta_verifica = mysqli_query($conexion, $cadena_verifica);
$row_verifica = mysqli_fetch_array($consulta_verifica);

if ($row_verifica[0]=='0') {
	$estado = '1';
}else if($row_verifica[0]=='1'){
	$estado = '0';
}
$cadena_modifica = "UPDATE tortilleria_subrecetasrenglones SET ACTIVO = '$estado' WHERE ID_ARTICULO = '$id_articulo' AND ID_SUBRECETA = '$subreceta'";
$modifica_estado = mysqli_query($conexion, $cadena_modifica);

 echo "ok";
?>