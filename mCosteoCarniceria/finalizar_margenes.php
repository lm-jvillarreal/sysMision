<?php
include '../global_seguridad/verificar_sesion.php';
$id_costeo=$_POST['id_costeo'];
$cadenaActualizar="UPDATE carniceria_costeo SET ESTATUS='2' WHERE ID='$id_costeo'";
$actualizar=mysqli_query($conexion,$cadenaActualizar);
echo "ok";
?>