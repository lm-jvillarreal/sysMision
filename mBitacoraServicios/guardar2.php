<?php
	include '../global_seguridad/verificar_sesion.php';

	$descripcion  = $_POST['descripcion'];
	$descripcion  = trim($descripcion);
	$gasto_total  = $_POST['gasto_total'];
	$seleccionado = $_POST['seleccionado'];
	$id_servicio  = $_POST['id_servicio'];
	$id_pago      = $_POST['id_pago'];
	$sucursal     = $_POST['sucursal'];
	$cantidad     = count($id_servicio);
	$existe       = "";


	if($id_pago == 0){
		for ($i=0; $i < $cantidad ; $i++) { 
			if($seleccionado[$i] != "0"){
				$existe = "SI";
				break;
			}
		}

		if($existe == "SI"){
			$cadena_principal = mysqli_query($conexion,"INSERT INTO pagos_servicios (descripcion, monto_total, id_sucursal, fecha, hora , activo, id_usuario) VALUES ('$descripcion','$gasto_total','$sucursal','$fecha','$hora','1','$id_usuario')");
			$cadena_select = mysqli_query($conexion,"SELECT MAX(id) FROM pagos_servicios");
			$row_select = mysqli_fetch_array($cadena_select);
			$folio = $row_select[0];
			for ($i=0; $i < $cantidad ; $i++) { 
				if($seleccionado[$i] == "1"){
					$cadena = mysqli_query($conexion,"INSERT INTO detalle_pago_servicios (id_pago,id_bitacora_servicio, fecha, hora, activo, id_usuario) VALUEs('$folio','$id_servicio[$i]','$fecha','$hora','1','$id_usuario')");
				}
			}
			echo "ok";
		}else{
			echo "vacio";
		}
	}else{
		$cadena_principal = mysqli_query($conexion,"UPDATE pagos_servicios SET descripcion = '$descripcion', id_sucursal = '$sucursal' WHERE id = '$id_pago'");
		for ($i=0; $i < $cantidad ; $i++) { 
			if($seleccionado[$i] == "1"){
				$cadena = mysqli_query($conexion,"INSERT INTO detalle_pago_servicios (id_pago,id_bitacora_servicio, fecha, hora, activo, id_usuario) VALUEs('$id_pago','$id_servicio[$i]','$fecha','$hora','1','$id_usuario')");
			}
		}
			echo "ok";
	}

?>