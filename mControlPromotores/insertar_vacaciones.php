<?php
	include '../global_seguridad/verificar_sesion.php';
	
	$id_promotor = $_POST['id_promotor_vacaciones'];
	$fecha1      = $_POST['fecha1'];
	$fecha2      = $_POST['fecha2'];

	if($fecha1 != "" && $fecha2 != ""){
		$cadena = mysqli_query($conexion,"INSERT INTO vacaciones_promotor (id_promotor, fecha_inicio, fecha_fin, fecha, hora, activo, id_usuario) VALUES ('$id_promotor','$fecha1','$fecha2', '$fecha','$hora','1','$id_usuario')");
		$cadena_prom = mysqli_query($conexion,"UPDATE promotores SET activo = '2' WHERE id = '$id_promotor'");
		echo "ok";
	}else{
		echo "vacio";
	}

?>
