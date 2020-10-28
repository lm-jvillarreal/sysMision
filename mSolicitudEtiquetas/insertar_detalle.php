<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("H:i:s");

$codigo = $_POST['codigo'];
$descripcion =$_POST['descripcion'];
$id_solicitud = $_POST['ide_solicitud'];

$cadena_insertar = "INSERT INTO detalle_solicitud (codigo, descripcion, id_solicitud, formato, fecha, hora, activo, usuario)VALUES('$codigo', '$descripcion', '$id_solicitud', '', '$fecha', '$hora', '1', '$id_usuario')";

$insertar_detalle = mysqli_query($conexion, $cadena_insertar);

echo "ok";
?>