<?php
include '../global_settings/conexion.php';

$nombre_modulo = $_POST['nombre_modulo'];
$nombre_carpeta = $_POST['nombre_carpeta'];
$descripcion_modulo = $_POST['descripcion_modulo'];

$cadena_duplicado = "SELECT * FROM modulos WHERE nombre = '$nombre_modulo'";
$consulta_duplicado = mysqli_query($conexion, $cadena_duplicado);
$cont_duplicado = mysqli_num_rows($consulta_duplicado);

if ($cont_duplicado>0) {
	echo "duplicado";
}elseif ($cont_duplicado==0) {
	
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$cadena_insertar = "INSERT INTO modulos (nombre, nombre_carpeta, descripcion, fecha, hora, activo, usuario) VALUES ('$nombre_modulo','$nombre_carpeta','$descripcion_modulo','$fecha','$hora','1','$id_usuario')";

$insertar_modulo = mysqli_query($conexion, $cadena_insertar);

echo "ok";
}
?>
