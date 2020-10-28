<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$id_solicitud = $_POST['id_solicitud'];

$cadena_impreso = "UPDATE solicitud_etiquetas SET estatus = '1' WHERE id = '$id_solicitud'";
$consulta_impreso = mysqli_query($conexion,$cadena_impreso);

echo "ok";
?>