<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"SELECT id, banco, terminacion, empresa, fecha_venta, autoriza, beneficiario, monto, nombre_cliente, direccion_cliente, telefono_cliente from control_cheques WHERE activo='1' and id = '$id'");
	$row = mysqli_fetch_array($cadena);

	$array = array( $row[0], //id_registro
	$row[1], //banco
	$row[2], //terminacion
	$row[3], //empresa
	$row[4], //fecha_venta
	$row[5],//autoriza
	$row[6],//beneficiario
	$row[7],//monto
	$row[8],//nombre_cliente
	$row[9],//direccion_cliente
	$row[10],//telefono_cliente
				);
	echo json_encode($array);
?>