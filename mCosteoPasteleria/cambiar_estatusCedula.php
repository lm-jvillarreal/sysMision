<?php
include '../global_seguridad/verificar_sesion.php';
$id_articulo = $_POST['id_articulo'];
$subreceta = $_POST['subreceta'];
$ide = $_POST['ide'];

$cadena_verifica = "SELECT ACTIVO FROM pasteleria_recetasventarenglones WHERE CLAVE_ARTICULO = '$id_articulo' AND ID = '$ide'";

$consulta_verifica = mysqli_query($conexion, $cadena_verifica);
$row_verifica = mysqli_fetch_array($consulta_verifica);

if ($row_verifica[0]=='0') {
	$estado = '1';
}else if($row_verifica[0]=='1'){
	$estado = '0';
}
$cadena_modifica = "UPDATE pasteleria_recetasventarenglones SET ACTIVO = '$estado' WHERE CLAVE_ARTICULO = '$id_articulo' AND ID_PRODUCTO = '$subreceta' AND ID = '$ide'";
$modifica_estado = mysqli_query($conexion, $cadena_modifica);

 echo "ok";
?>