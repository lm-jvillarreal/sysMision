<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("H:i:s");

	$id_promotor = $_POST['id_promotor'];

	$cadena_verificar = mysqli_query($conexion,"SELECT id, hora_salida FROM registro_entrada WHERE id_promotor = '$id_promotor' AND fecha = '$fecha' AND hora_salida is null");
	$existen = mysqli_num_rows($cadena_verificar);

	if ($existen == 0){
		echo "existe";
	}else{
		$actulizar = mysqli_query($conexion,"UPDATE registro_entrada SET hora_salida = '$hora' WHERE id_promotor ='$id_promotor' AND fecha = '$fecha'");
		echo "ok";
	}
?>