<?php
include '../global_seguridad/verificar_sesion.php';

$nombre_perfil = $_POST['nombre_perfil'];
$descripcion_perfil = $_POST['descripcion_perfil'];

$cadena_duplicado = "SELECT * FROM perfil WHERE nombre = '$nombre_perfil'";
$consulta_duplicado = mysqli_query($conexion, $cadena_duplicado);
$cont_duplicado = mysqli_num_rows($consulta_duplicado);

if ($cont_duplicado>0) {
	echo "duplicado";
}elseif ($cont_duplicado==0) {
	
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

//Se inserta el perfil en la tabla correspondiente
$cadena_insertar = "INSERT INTO perfil (nombre, descripcion, fecha, hora, activo, usuario)VALUES ('$nombre_perfil','$descripcion_perfil','$fecha','$hora','1','$id_usuario')";
$insertar_perfil = mysqli_query($conexion, $cadena_insertar);

//Guardamos el id del perfil recien creado en una variable local
$cadena_perfil = "SELECT MAX(id) FROM perfil";
$consulta_max_perfil = mysqli_query($conexion, $cadena_perfil);
$row_id_perfil = mysqli_fetch_array($consulta_max_perfil);

//Se inserta el registro en detalle_perfil
$cadena_modulos = "SELECT id FROM modulos WHERE panel_control = '0'";
$consulta_modulos = mysqli_query($conexion, $cadena_modulos);
while ($row_modulos = mysqli_fetch_array($consulta_modulos)) {
	$cadena_insertar_detalle = "INSERT INTO detalle_perfil (id_perfil, id_modulo, fecha, hora, activo, usuario)VALUES('$row_id_perfil[0]','$row_modulos[0]','$fecha','$hora','1','$id_usuario')";
	$insertar_detalle = mysqli_query($conexion, $cadena_insertar_detalle);
}
echo "ok";
}
?>
