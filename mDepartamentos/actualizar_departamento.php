<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

	$id                  = $_POST['id'];
	$clave_departamento  = $_POST['clave_departamento'];
	$nombre_departamento = $_POST['nombre_departamento'];
	$abreviatura         = $_POST['abreviatura'];
	$agrupacion          = $_POST['id_agrupacion'];

	$cadena = mysqli_query($conexion,"UPDATE departamentos SET clave_departamento = '$clave_departamento', id_agrupacion = '$agrupacion',nombre = '$nombre_departamento',abreviatura = '$abreviatura',fecha = '$fecha',hora = '$hora',id_usuario = '$id_usuario' WHERE id = '$id'");
	echo "ok";

?>
