<?php
include '../global_seguridad/verificar_sesion.php';
$sucursal=$_POST['sucursal'];
$cadenaCeros="UPDATE covid_conteo_clientes SET CONTEO_CLIENTES='0' WHERE SUCURSAL='$sucursal'";
$ceros=mysqli_query($conexion,$cadenaCeros);
echo "ok";
?>