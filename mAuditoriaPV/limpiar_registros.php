<?php
include '../global_seguridad/verificar_sesion.php';

$cadenaLimpiar = "DELETE FROM auditoria_pv WHERE usuario = '$id_usuario' AND activo = '1'";
$consultaLimpiar = mysqli_query($conexion,$cadenaLimpiar);

echo "ok";
?>