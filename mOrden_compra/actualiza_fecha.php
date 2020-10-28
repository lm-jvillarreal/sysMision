<?php
include '../global_seguridad/verificar_sesion.php';

$id_orden = $_POST['id_orden'];
$fecha_llegada = $_POST['fecha'];

date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$cadena_actualiza = "UPDATE orden_compra SET fecha_llegada = '$fecha_llegada' WHERE id = '$id_orden'";
$actualiza_fecha = mysqli_query($conexion, $cadena_actualiza);

echo "ok";
?>