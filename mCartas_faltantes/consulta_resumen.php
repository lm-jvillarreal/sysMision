<?php
	include '../global_seguridad/verificar_sesion.php';

	$sucursal  = $_POST['sucursal'];
	$fecha1    = $_POST['fecha1'];
	$fecha2    = $_POST['fecha2'];
	$proveedor = $_POST['proveedor'];

	if(!empty($sucursal)){
    	$filtro_sucursal = " AND id_sucursal = '$sucursal'";
	}elseif(empty($sucursal)){
	    $filtro_sucursal = "";
	}
	if(!empty($proveedor)){
		$proveedor = trim($proveedor);
		$filtro_proveedor = " AND numero_proveedor = '$proveedor'";
	}else{
		$filtro_proveedor = "";
	}

	/////////////// cantidad de registros///////////
	$cadena1 = mysqli_query($conexion,"SELECT COUNT(*) FROM carta_faltante WHERE
	activo = '2' AND fecha_afectacion BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_sucursal.$filtro_proveedor);
	$row_total = mysqli_fetch_array($cadena1);
	$total     = number_format($row_total[0], 0, '.', ',');

	/////////////// monto total///////////
	$cadena2 = mysqli_query($conexion,"SELECT SUM(total_diferencia) FROM carta_faltante WHERE
	activo = '2' AND fecha_afectacion BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_sucursal.$filtro_proveedor);
	$row_monto   = mysqli_fetch_array($cadena2);
	$total_monto = number_format($row_monto[0], 0, '.', ',');

	$array = array($total,'$ '.$total_monto);
	echo json_encode($array);
?>