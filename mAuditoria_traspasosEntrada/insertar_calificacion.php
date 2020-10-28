<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");


$fecha_inicio = $_POST['fecha_inicial'];
$fecha_fin = $_POST['fecha_final'];
$sucursal = $_POST['sucursal'];
$recibidos = $_POST['txt_recibidos'];
$pendientes = $_POST['txt_pendientes'];
$calificacion = $_POST['p_calificacion'];

$cadena_validar = "SELECT * FROM calificacion_traspasos  WHERE fecha_calificacion = '$fecha_fin' AND sucursal = '$sucursal'";
$consulta_validar = mysqli_query($conexion, $cadena_validar);
$conteo_validar = mysqli_num_rows($consulta_validar);
if ($conteo_validar>=1) {
	echo "existe";
}
else{
$cadena_insertar = "INSERT INTO calificacion_traspasos (fecha_calificacion, sucursal, t_capturados, t_pendientes, calificacion, fecha, hora, activo, usuario) VALUES ('$fecha_fin', '$sucursal', '$recibidos', '$pendientes', '$calificacion', '$fecha', '$hora', '1', '$id_usuario')";

$insertar_calificacion = mysqli_query($conexion, $cadena_insertar);

echo "ok";
}
?>