<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

$id_categoria = $_POST['id_categoria'];
$nombre_categoria = $_POST['nombre_categoria'];
$desc_categoria = $_POST['desc_categoria'];

if (empty($id_categoria)) {
	$cadena_insertar = "INSERT INTO categorias_modulos (nombre, descripcion, fecha, hora, activo, usuario)VALUES('$nombre_categoria', '$desc_categoria', '$fecha', '$hora', '1', '$id_usuario')";
}else{
	$cadena_insertar = "UPDATE categorias_modulos SET nombre = '$nombre_categoria', descripcion = '$desc_categoria', fecha = '$fecha', hora = '$hora', activo = '1', usuario = '$id_usuario' WHERE id = '$id_categoria'";
}
$insertar_categoria = mysqli_query($conexion, $cadena_insertar);

echo "ok";
?>