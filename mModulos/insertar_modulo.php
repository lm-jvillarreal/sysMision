<?php
include '../global_seguridad/verificar_sesion.php';

$nombre_modulo = $_POST['nombre_modulo'];
$nombre_carpeta = $_POST['nombre_carpeta'];
$descripcion_modulo = $_POST['descripcion_modulo'];
$categoria = $_POST['id_categoria'];
$icono = $_POST['icono'];
$tema = $_POST['tema'];
$panel_control = $_POST['panel_control'];

if ($panel_control != '1') {
	$panel_control = '0';
}

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

$cadena_insertar = "INSERT INTO modulos (nombre, nombre_carpeta, descripcion, panel_control, categoria, icono, tema, fecha, hora, activo, usuario) VALUES ('$nombre_modulo','$nombre_carpeta','$descripcion_modulo','$panel_control','$categoria','$icono','$tema','$fecha','$hora','1','$id_usuario')";

$insertar_modulo = mysqli_query($conexion, $cadena_insertar);

$cadena_id = "SELECT MAX(id) FROM modulos";
$consulta_id = mysqli_query($conexion, $cadena_id);
$row_id = mysqli_fetch_array($consulta_id);

$cadena_detalle_perfil = "INSERT INTO detalle_perfil (id_perfil, id_modulo, fecha, hora, activo, usuario)VALUES('1','$row_id[0]','$fecha','$hora','1','$id_usuario')";
$insertar_detalle_perfil = mysqli_query($conexion, $cadena_detalle_perfil);

$cadena_usuario = "SELECT id FROM usuarios WHERE id_perfil = '1'";
$consulta_usuario = mysqli_query($conexion, $cadena_usuario);

while ($row_usuario = mysqli_fetch_array($consulta_usuario)) {
	$insertar_detalle = "INSERT INTO detalle_usuario (id_usuario, id_modulo, id_categoria, fecha, hora, activo, usuario) VALUES ('$row_usuario[0]','$row_id[0]','$categoria','$fecha','$hora','1','$id_usuario')";
	$inserta_detalle = mysqli_query($conexion, $insertar_detalle);
}
echo "ok";
}
?>
