<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$codigo = $_POST['codigo'];
$descripcion = $_POST['descripcion'];
$caducidad = $_POST['caducidad'];
$cantidad = $_POST['cantidad'];
$precio_venta = $_POST['precio_venta'];
$oferta = $_POST['oferta'];
$lote = $_POST['lote'];

$cadena_insertar = "INSERT INTO far_medicamentosCaducan (codigo_articulo, descripcion_articulo, precio_publico, precio_oferta, cantidad, fecha_caducidad, sucursal, estatus, fecha, hora, activo, usuario, lote) VALUES ('$codigo', '$descripcion', '$precio_venta', '$oferta', '$cantidad', '$caducidad', '$id_sede', '1', '$fecha', '$hora', '1', '$id_usuario', '$lote')";
$insertar_registro = mysqli_query($conexion, $cadena_insertar);
echo "ok";
?>