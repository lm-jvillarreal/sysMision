<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('h:i:s');

	$fecha    = strtotime('-1 day', strtotime($fecha));
    $fecha = date('Y-m-d', $fecha);

	$abono  = $_POST['abono'];
	$folio  = $_POST['folio'];

	if($abono != "" && $abono != "0"){
		$cadena = mysqli_query($conexion,"INSERT INTO abonos (folio,abono,id_usuario,fecha,hora,id_sucursal)
				VALUES ('$folio','$abono','$id_usuario','$fecha','$hora','$id_sede')");
		echo "ok";
	}
	else{
		echo "1";
	}
?>