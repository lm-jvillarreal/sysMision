<?php
include '../global_seguridad/verificar_sesion.php';
$fecha=date("Y-m-d H:i:s");
$cadenaCorte="UPDATE valecaja_provisional SET ESTATUS='2', FECHAHORA_CORTE='$fecha' WHERE ESTATUS='1'";
$corte=mysqli_query($conexion,$cadenaCorte);
echo "ok";
?>