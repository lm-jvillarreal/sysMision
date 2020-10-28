<?php
include '../global_seguridad/verificar_sesion.php';

$persona = $_POST['persona'];
$sucursal = $_POST['sucursal'];
$nombre = $_POST['nombre'];
$ap_paterno = $_POST['ap_paterno'];
$ap_materno = $_POST['ap_materno'];

$cadena_actualizar = "UPDATE personas SET id_sede = '$sucursal', nombre = '$nombre', ap_paterno = '$ap_paterno', ap_materno = '$ap_materno' WHERE id = '$persona'";
$actualiza_sucursal = mysqli_query($conexion, $cadena_actualizar);
echo "ok";
?>