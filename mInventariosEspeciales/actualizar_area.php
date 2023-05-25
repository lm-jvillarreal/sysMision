<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");

$id=$_POST['id'];
$area=$_POST['area'];

$cadenaActualizar="UPDATE vidvig_areas SET AREA='$area', FECHAHORA='$fechahora', ACTIVO='1', USUARIO='$id_usuario' WHERE ID='$id'";
$actualizar=mysqli_query($conexion,$cadenaActualizar);
echo "ok";
?>