<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("H:i:s");

$numero_proveedor = $_POST['numero_proveedor'];
$nombre_proveedor = $_POST['nombre_proveedor'];
$orden_compra = $_POST["orden_compra"];
$id_orden = $_POST["id_orden"];
$id_sucursal = $_POST["id_sucursal"];
$nombre_sucursal = $_POST["nombre_sucursal"];
$no_ficha = $_POST["no_ficha"];
$no_factura = $_POST["no_factura"];
$total = $_POST["total"];
$observaciones = $_POST["observaciones"];
$completo = $_POST["completo"];
$id_proveedor = $_POST["id_proveedor"];

if ($completo == "no") {
	//Solo actualizar orden de compra
	$cadena_actualizar = "UPDATE orden_compra SET fecha_final = '$fecha', hora_final = '$hora', status = '3', usuario_final = '$id_usuario', activo = '0', completo = '1' WHERE id = '$id_orden'";
	$actualizar_orden = mysqli_query($conexion, $cadena_actualizar);
	//echo $cadena_insertar_libro;
} elseif ($completo=="si") {
	
	$cadena_actualizar = "UPDATE orden_compra SET fecha_final = '$fecha', hora_final = '$hora', status = '3', usuario_final = '$id_usuario', activo = '0', completo = '1' WHERE id = '$id_orden'";
	$actualizar_orden = mysqli_query($conexion, $cadena_actualizar);

	//$cadena_insertar_libro = "INSERT INTO libro_diario (id_proveedor, sucursal, numero_nota, numero_factura, total, fecha, hora, usuario, observaciones, orden_compra, activo)VALUES('$numero_proveedor','$id_sucursal','$no_ficha','$no_factura','$total','$fecha','$hora','$id_usuario','$observaciones','$id_orden', '1')";
	//$insertar_libro_diario = mysqli_query($conexion, $cadena_insertar_libro);

	$cadena_carta_faltante = "INSERT INTO carta_faltante (id_orden, no_orden, no_factura, id_sucursal, fecha_elaboracion, hora_elaboracion, activo, usuario, id_proveedor, numero_proveedor)VALUES('$id_orden','$orden_compra','$no_factura','$id_sucursal','$fecha','$hora','1','$id_usuario','$id_proveedor','$numero_proveedor')";
	$insertar_carta_faltante = mysqli_query($conexion, $cadena_carta_faltante);
}

$cadena_insertar_libro = "INSERT INTO libro_diario (id_proveedor, sucursal, numero_nota, numero_factura, total, fecha, hora, usuario, observaciones, orden_compra, activo)VALUES('$numero_proveedor','$id_sucursal','$no_ficha','$no_factura','$total','$fecha','$hora','$id_usuario','$observaciones','$id_orden', '1')";
$insertar_libro_diario = mysqli_query($conexion, $cadena_insertar_libro);
?>