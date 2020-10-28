<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

	$nombre = $_POST['nombre'];
	//$abreviatura         = $_POST['abreviatura'];
	//$agrupacion          = $_POST['id_agrupacion'];

	$verificar=mysqli_query($conexion,"SELECT id_permiso FROM permisos WHERE nombre = '$nombre'");
	$existe = mysqli_num_rows($verificar);
	
	if($existe == 0){
		$cadena = mysqli_query($conexion,"INSERT INTO permisos(nombre,fecha,hora,activo)
					VALUES('$nombre','$fecha','$hora','1')");
		echo "ok";
	}
	else{
		echo "duplicado";
	}

?>
