<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

$proveedor = $_POST['proveedor'];
$codigo = $_POST['codigo'];
$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];

$cadena_insertar = "INSERT INTO cambios (id_proveedor, codigo, producto, cantidad, estatus, fecha, hora, activo, usuario, id_sucursal)VALUES('$proveedor', '$codigo', '$descripcion', '$cantidad', '0', '$fecha', '$hora', '1', '$id_usuario', '$id_sede')";

$insertar_cambio = mysqli_query($conexion, $cadena_insertar);

echo "ok";
?>