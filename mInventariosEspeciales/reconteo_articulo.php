<?php
include '../global_seguridad/verificar_sesion.php';
$renglon = $_POST['renglon'];
$cadenaReconteo="UPDATE vidvig_renglonesauditoria SET ESTATUS='3' WHERE ID='$renglon'";
$consultaReconteo=mysqli_query($conexion,$cadenaReconteo);
echo "ok";
?>