<?php
include '../global_seguridad/verificar_sesion.php';

$id_registro = $_POST['id_registro'];

$cadena_actualizar = "UPDATE costos_cero SET estatus = '3' WHERE id = '$id_registro'";
$consulta_baja = mysqli_query($conexion, $cadena_actualizar);
echo "ok";
?>