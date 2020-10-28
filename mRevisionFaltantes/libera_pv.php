<?php
include '../global_seguridad/verificar_sesion.php';

$id_registro = $_POST['id_registro'];

$cadena_libera = "UPDATE faltantes_pasven SET estatus = '7' WHERE id = '$id_registro'";
$libera_pv = mysqli_query($conexion, $cadena_libera);

echo "ok";
?>