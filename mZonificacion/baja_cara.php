<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fechahora=date("Y-m-d H:i:s");
$id=$_POST['id'];
$motivo = $_POST['motivo'];
$cadenaBaja="UPDATE inv_caramuebles SET ACTIVO='0', MOTIVO_BAJA='$motivo', FECHAHORA='$fechahora', USUARIO='$id_usuario' WHERE ID='$id'";
$consultaBaja=mysqli_query($conexion,$cadenaBaja);
echo "ok";
?>