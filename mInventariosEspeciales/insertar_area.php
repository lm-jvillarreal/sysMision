<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");

$area=$_POST['area'];

$cadenaInsertar="INSERT INTO vidvig_areas (AREA, FECHAHORA, ACTIVO, USUARIO)VALUES('$area','$fechahora','1','$id_usuario')";
$insertar = mysqli_query($conexion,$cadenaInsertar);
echo "ok";
?>