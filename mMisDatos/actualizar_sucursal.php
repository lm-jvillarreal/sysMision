<?php
include '../global_seguridad/verificar_sesion.php';

$sucursal = $_POST['sucursal'];

$cadena_actualizar = "UPDATE personas SET id_sede = '$sucursal' WHERE id = '$id_persona'";
$actualiza_sucursal = mysqli_query($conexion, $cadena_actualizar);
echo "ok";
?>