<?php
	include '../global_seguridad/verificar_sesion.php';

	$nombre      = $_POST['nombre'];
	$descripcion = $_POST['descripcion'];
	$id_sucursal = $_POST['id_sucursal'];
	$existencia  = $_POST['existencia'];
	$tipo        = $_POST['tipo'];
	$t_bodega    = $_POST['t_bodega'];
	$id_registro = $_POST['id_registro'];

	if($tipo == 1){
		$id_proveedor = $_POST['id_proveedor'];
		$proveedor    = $id_proveedor;
	}else{
		$proveedor    = $_POST['proveedor'];
	}

	if($id_registro == 0){
		$cadena = "INSERT INTO catalogo_materiales2 (nombre, descripcion, id_sucursal, existencia, tipo, proveedor, pedido, id_tipo_bodega, fecha, hora, activo, id_usuario) VALUES ('$nombre','$descripcion','$id_sucursal','$existencia','$tipo','$proveedor','0','$t_bodega','$fecha','$hora','1','$id_usuario')";
	}else{
		$cadena = "UPDATE catalogo_materiales2 SET nombre = '$nombre', descripcion = '$descripcion', id_sucursal = '$id_sucursal', existencia = '$existencia', tipo = '$tipo', proveedor = '$proveedor', fecha_edito = '$fecha', hora_edito = '$hora', id_usuario_edito = '$id_usuario', id_tipo_bodega = '$t_bodega' WHERE id = '$id_registro'";
	}
	$consulta = mysqli_query($conexion,$cadena);
	echo "ok";
?>