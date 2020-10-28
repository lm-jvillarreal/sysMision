<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_pedido   = $_POST['id_pedido'];
	$id          = $_POST['id'];
	$surtir      = $_POST['surtir'];
	$id_material = $_POST['id_material'];
	$cantidad    = count($id);

	for ($i=0; $i < $cantidad ; $i++) { 
		$cadenav = mysqli_query($conexion,"SELECT cantidad FROM detalle_pedido WHERE id_pedido = '$id_pedido' AND id = '$id[$i]'");
		$rowv = mysqli_fetch_array($cadenav);
		if($surtir[$i] <= $rowv[0]){}else{
			echo "verifica";
			return false;
		}		
	}


	$cadena = mysqli_query($conexion,"UPDATE pedido_materiales SET estatus = '4' WHERE id = '$id_pedido'");
	for ($i=0; $i < $cantidad; $i++) { 
		$cadena2 = mysqli_query($conexion,"UPDATE detalle_pedido SET surtido = '$surtir[$i]' WHERE id = '$id[$i]'");
		$cadena2 = mysqli_query($conexion,"UPDATE catalogo_materiales2 SET existencia = existencia - '$surtir[$i]' WHERE id = '$id_material[$i]'");
		$cadena3 = mysqli_query($conexion,"INSERT INTO materiales_movimientos (id_material, id_pedido, tipo, cantidad, fecha, hora, id_usuario) VALUES('$id_material[$i]','$id_pedido','1','$surtir[$i]','$fecha','$hora','$id_usuario')");
	}
    echo "ok";
?>