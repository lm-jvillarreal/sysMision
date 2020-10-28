<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_pago = $_POST['id_pago'];

	$cadena = mysqli_query($conexion,"SELECT descripcion, monto_total, id_sucursal, (SELECT nombre FROM sucursales WHERE sucursales.id = pagos_servicios.id_sucursal ) FROM pagos_servicios WHERE id = '$id_pago'");

	$row = mysqli_fetch_array($cadena);

	$array = array($row[0],$row[1],$row[2],$row[3]);
	echo json_encode($array);
?>