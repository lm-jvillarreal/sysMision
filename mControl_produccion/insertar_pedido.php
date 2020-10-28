<?php
include '../global_seguridad/verificar_sesion.php';

$cve_producto = $_POST['cod_prod'];
$desc_producto = $_POST['desc_prod'];
$cantidad = $_POST['pedido'];
$observaciones = $_POST['observaciones'];

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
$conteo = count($cve_producto);

$folio = date("Y").date("m").date("d");



for ($i=0; $i < $conteo; $i++) {
	$cadena_insertar = "INSERT INTO cp_pedido_pan (folio_pedido, cve_producto, desc_producto, cantidad_pedido, observaciones, sucursal, fecha, hora, activo, usuario)VALUES('$folio','$cve_producto[$i]', '$desc_producto[$i]', '$cantidad[$i]', '$observaciones[$i]', '$id_sede', '$fecha', '$hora', '1', '$id_usuario')";
	$consulta_insertar = mysqli_query($conexion, $cadena_insertar);
}
echo "ok";
?>