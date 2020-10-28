<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("H:i:s");
//$anio = date("Y");
$anio = '2019';

$sucursal = $_POST['sucursal'];
$concepto = $_POST['concepto'];
$proveedor = $_POST['proveedor'];
$valor = $_POST['valor'];
$impuesto = $_POST['impuesto'];
$comentarios = $_POST['comentarios'];

$cadena_insertar="INSERT INTO solicitud_nc (concepto, anio, usuario_solicita, estatus, sucursal, proveedor, monto, comentarios, fecha, hora, activo, usuario, impuesto)VALUES('$concepto','$anio', '$id_usuario', '1', '$sucursal', '$proveedor', '$valor', '$comentarios', '$fecha', '$hora', '1', '$id_usuario', '$impuesto')";
$insertar_solicitud = mysqli_query($conexion, $cadena_insertar);

echo "ok";
?>