<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");
$fecha_solicitud = date("Y-m-d H:i:s");

$nombre = $_POST['nombre'];
$formato = $_POST['formato'];

$cadena_insertar = "INSERT INTO solicitud_etiquetas (nombre, formato, sucursal, estatus, tipo, fecha_solicitud, fecha, hora, activo, usuario_solicita)VALUES('$nombre', '$formato', '$id_sede', '0', '0', '$fecha_solicitud', '$fecha', '$hora', '0', '$id_usuario')";
$insertar_solicitud = mysqli_query($conexion, $cadena_insertar);

$cadena_maximo = "SELECT MAX(id) FROM solicitud_etiquetas";
$consulta_maximo = mysqli_query($conexion, $cadena_maximo);
$row_maximo = mysqli_fetch_array($consulta_maximo);

echo $row_maximo[0];
?>