<?php
	include '../global_seguridad/verificar_sesion.php';

	$sucursal = $_POST['sucursal'];
	$fecha1   = $_POST['fecha1'];
	$fecha2   = $_POST['fecha2'];

	if(!empty($sucursal)){
    	$filtro_sucursal = " AND sucursal = '$sucursal'";
	}elseif(empty($sucursal)){
	    $filtro_sucursal = "";
	}

	/////////////// cantidad de registros///////////
	$cadena1 = mysqli_query($conexion,"SELECT COUNT(*) FROM bitacora_cambios WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND liberado = '1'".$filtro_sucursal);
	$row_total = mysqli_fetch_array($cadena1);
	$total     = number_format($row_total[0], 0, '.', ',');

	////////////// cantidad de ofertas //////////////////
	$cadena_ofertas = mysqli_query($conexion,"SELECT COUNT(*) FROM bitacora_cambios WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND tipo = 'O' AND liberado = '1' ".$filtro_sucursal);
	$row_oferta = mysqli_fetch_array($cadena_ofertas);

	if($row_oferta[0] == 0 ){
		$porcentaje_oferta = 0;
	}else{
		$porcentaje_oferta = ($row_oferta[0] * 100) / $row_total[0];
		$porcentaje_oferta = round($porcentaje_oferta, 2) . '%';
	}
	
	$texto_oferta = $porcentaje_oferta." del total capturado";

	////////////// cantidad de cambios //////////////////
	$cadena_cambios = mysqli_query($conexion,"SELECT COUNT(*) FROM bitacora_cambios WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND tipo = 'C' AND liberado = '1' ".$filtro_sucursal);
	$row_cambio = mysqli_fetch_array($cadena_cambios);

	if($row_cambio[0] == 0 ){
		$porcentaje_cambio = 0;
	}else{
		$porcentaje_cambio = ($row_cambio[0] * 100) / $row_total[0];
		$porcentaje_cambio = round($porcentaje_cambio, 2) . '%';
	}

	$texto_cambio = $porcentaje_cambio." del total capturado";

	////////////// cantidad de validados //////////////////
	$cadena_validados = mysqli_query($conexion,"SELECT COUNT(*) FROM bitacora_cambios WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND liberado = '1' AND validado = '1'".$filtro_sucursal);
	$row_validado = mysqli_fetch_array($cadena_validados);

	if($row_validado[0] == 0 ){
		$porcentaje_validado = 0;
	}else{
		$porcentaje_validado = ($row_validado[0] * 100) / $row_total[0];
		$porcentaje_validado = round($porcentaje_validado, 2) . '%';
	}

	
	$texto_validado = $porcentaje_validado." del total capturado";

	////////////// cantidad de liberados //////////////////
	$cadena_liberados = mysqli_query($conexion,"SELECT COUNT(*) FROM bitacora_cambios WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND liberado = '1' AND validado = '0'".$filtro_sucursal);
	$row_liberado = mysqli_fetch_array($cadena_liberados);

	if($row_validado[0] == 0 ){
		$porcentaje_liberado = 0;
	}else{
		$porcentaje_liberado = ($row_liberado[0] * 100) / $row_total[0];
		$porcentaje_liberado = round($porcentaje_liberado, 2) . '%';
	}

	
	$texto_liberado = $porcentaje_liberado." del total capturado";

	$array = array($total, //total
				   	$row_oferta[0], //Total estatus 2
						$porcentaje_oferta, //Porcentje estatus 2
						$texto_oferta,
						$row_cambio[0], //Total estatus 2
						$porcentaje_cambio, //Porcentje estatus 2
						$texto_cambio,
						$row_validado[0], //Total estatus 2
						$porcentaje_validado, //Porcentje estatus 2
						$texto_validado,
						$row_liberado[0], //Total estatus 2
						$porcentaje_liberado, //Porcentje estatus 2
						$texto_liberado);
	echo json_encode($array);
?>