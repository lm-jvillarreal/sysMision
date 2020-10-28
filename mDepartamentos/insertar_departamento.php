<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

	$clave_departamento  = $_POST['clave_departamento'];
	$nombre_departamento = $_POST['nombre_departamento'];
	$abreviatura         = $_POST['abreviatura'];
	$agrupacion          = $_POST['id_agrupacion'];

	$verificar=mysqli_query($conexion,"SELECT id FROM departamentos WHERE nombre = '$nombre_departamento'");
	$existe = mysqli_num_rows($verificar);
	
	if($existe == 0){
		$cadena = mysqli_query($conexion,"INSERT INTO departamentos(clave_departamento,id_agrupacion,nombre,abreviatura,fecha,hora,id_usuario,activo)
					VALUES('$clave_departamento','$agrupacion','$nombre_departamento','$abreviatura','$fecha','$hora','$id_usuario','1')");
		echo "ok";
	}
	else{
		echo "duplicado";
	}

?>
