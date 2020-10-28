<?php
include '../global_seguridad/verificar_sesion.php';

$id_registro = $_POST['id_registro'];

$cadenaDesactiva = "UPDATE dispersion_boletos SET activo = '0' WHERE sucursal = '$id_sede'";
$consultaDesactiva = mysqli_query($conexion, $cadenaDesactiva);

$cadenaActiva = "UPDATE dispersion_boletos SET activo = '1' WHERE id = '$id_registro'";
$consultaActiva = mysqli_query($conexion, $cadenaActiva);
echo "ok";
?>