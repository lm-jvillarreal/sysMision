<?php
include '../global_seguridad/verificar_sesion.php';
$folio=$_POST['folio'];
$cantidad=$_POST['cantidad'];

$cadenaActualiza="UPDATE vidvig_renglonesauditoria SET CANTIDAD='$cantidad', ESTATUS='2' WHERE ID='$folio'";
$actualizaCantidad=mysqli_query($conexion,$cadenaActualiza);
echo "ok";
?>