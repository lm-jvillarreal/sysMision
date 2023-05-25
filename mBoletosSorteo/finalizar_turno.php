<?php
include '../global_seguridad/verificar_sesion.php';
$cadenaFinalizar="DELETE FROM registro_boletos2 WHERE usuario='$id_usuario' AND estatus='1' AND sucursal='$id_sede'";
$consultaFinalizar=mysqli_query($conexion,$cadenaFinalizar);
echo "ok";
?>