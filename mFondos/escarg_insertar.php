<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
//$anio = date("Y");
$anio = '2019';

$fecha_afectacion = $_POST['fecha_afectacion'];
$movimiento = $_POST['movimiento'];
$folio = $_POST['folio'];
$valor = $_POST['valor'];
$concepto = 'FONDO';
$id_comprador = $_POST['id_comprador'];
$proveedor = $_POST['proveedor'];
$comentario = $_POST['comentarios'];
$sucursal = $_POST['suc'];

$cadena_validar = "SELECT * FROM fondos WHERE folio_movimiento = '$folio' and tipo_movimiento = '$movimiento'";
$consulta_validar = mysqli_query($conexion, $cadena_validar);
$row_validar = mysqli_fetch_array($consulta_validar);
$num_validar = COUNT($row_validar);

if ($num_validar > 0) {
	echo "repetido";
}else{

$cadena_proveedor = "SELECT PROC_NOMBRE FROM CXP_PROVEEDORES WHERE PROC_CVEPROVEEDOR = '$proveedor'";
$consulta_proveedor = oci_parse($conexion_central, $cadena_proveedor);
oci_execute($consulta_proveedor);
$row_proveedor = oci_fetch_row($consulta_proveedor);

$cadena_aportacion = "INSERT INTO fondos (tipo_movimiento, folio_movimiento, fecha_afectacion, id_sucursal, concepto, id_comprador, cve_proveedor, nombre_proveedor, total, comentarios, fecha, hora, activo, usuario)VALUES('$movimiento','$folio','$fecha_afectacion','$sucursal','$concepto','$id_comprador','$proveedor','$row_proveedor[0]','$valor','$comentario','$fecha','$hora','1','$id_usuario')";

$inserta_aportacion = mysqli_query($conexion, $cadena_aportacion);

echo "ok";
}
?>