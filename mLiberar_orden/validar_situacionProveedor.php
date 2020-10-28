<?php
include '../global_seguridad/verificar_sesion.php';

$clave_proveedor = $_POST['clave_proveedor'];

$cadena_devoluciones = "SELECT * FROM devoluciones where status = '0' AND numero_proveedor = '$clave_proveedor' AND id_sucursal = '$id_sede'";
$consulta_devoluciones = mysqli_query($conexion, $cadena_devoluciones);
$conteo_devoluciones = mysqli_num_rows($consulta_devoluciones);

$cadena_cambios = "SELECT * FROM cambios WHERE estatus = '0' AND id_proveedor = '$clave_proveedor' AND id_sucursal = '$id_sede'";
$consulta_cambios = mysqli_query($conexion, $cadena_cambios);
$conteo_cambios = mysqli_num_rows($consulta_cambios);

if ($conteo_devoluciones>0 AND $conteo_cambios==0) {
	echo "devoluciones";
}elseif($conteo_devoluciones==0 AND $conteo_cambios>0){
	echo "cambios";
}elseif ($conteo_devoluciones>0 AND $conteo_cambios>0) {
	echo "ambos";
}else{
	echo "libre";
}
?>