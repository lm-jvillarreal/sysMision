<?php
include '../global_seguridad/verificar_sesion.php';

$cadena_liberar = "UPDATE registro_boletos SET estatus = '3' WHERE (estatus = '1' OR estatus = '2') AND usuario = '$id_usuario' AND sucursal = '$id_sede'";
$libera_ticket = mysqli_query($conexion, $cadena_liberar);
echo "ok";
?>