<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("H:i:s");

$id_actividad    = $_POST['id_actividad'];
$id_personas     = $_POST['id_persona'];
$actividad       = $_POST['actividad'];
$fecha_actividad = $_POST['fecha'];

if ($id_actividad == 0) {
	$cadena_insertar = "INSERT INTO actividades_usuario (id_persona, actividad,fecha_realizacion, fecha, hora, activo, id_usuario,tipo)VALUES('$id_personas', '$actividad', '$fecha_actividad', '$fecha', '$hora', '1', '$id_usuario','1')";
}else{
	$cadena_insertar = "UPDATE actividades_usuario SET actividad = '$actividad', fecha_realizacion = '$fecha_actividad', fecha = '$fecha', hora = '$hora', activo = '1', id_usuario = '$id_usuario' WHERE id = '$id_actividad'";
}
$insertar = mysqli_query($conexion, $cadena_insertar);

echo "ok";
?>