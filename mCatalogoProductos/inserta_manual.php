<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fecha = date("Y-m-d");
$hora = date("H:i:s");

$codigo = $_POST['codigo'];
$um = $_POST['unidad_medida'];
$depto = $_POST['depto'];

$cadenaInsertar = "INSERT INTO cp_productos (departamento, artc_articulo, um, fecha, hora, activo, usuario)VALUES('$depto','$codigo', '$um', '$fecha', '$hora', '1', '$id_usuario')";
$insertar = mysqli_query($conexion, $cadenaInsertar);
echo "ok";
?>