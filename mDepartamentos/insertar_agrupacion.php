<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');

	$fecha=date("Y-m-d"); 
	$hora=date ("H:i:s");

	$nombre_agrupacion  = $_POST['nombre_agrupacion'];

	$verificar=mysqli_query($conexion,"SELECT id FROM agrupaciones WHERE nombre = '$nombre_agrupacion'");
	$existe = mysqli_num_rows($verificar);
	
	if($existe == 0){
		$cadena = mysqli_query($conexion,"INSERT INTO agrupaciones(nombre,fecha,hora,id_usuario,activo)
					VALUES('$nombre_agrupacion','$fecha','$hora','$id_usuario','1')");
		echo "ok";
	}
	else{
		echo "duplicado";
	}

?>
