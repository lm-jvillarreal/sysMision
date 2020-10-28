<?php
include '../global_seguridad/verificar_sesion.php';
$id_registro = $_POST['id_registro'];

$cadena_cancela = "UPDATE carta_faltante SET activo = '3' WHERE id = '$id_registro'";
$consulta_cancela = mysqli_query($conexion, $cadena_cancela);

echo "ok";
?>