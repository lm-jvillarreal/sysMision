<?php
include '../global_seguridad/verificar_sesion.php';

$id_cambio = $_POST['id_cambio'];
$nombre_recibe = $_POST['nombre_recibe'];

$cadenaRecibe="UPDATE bitacora_cambios SET entregado='$nombre_recibe' WHERE id='$id_cambio'";
$recibe=mysqli_query($conexion,$cadenaRecibe);
echo "ok";
?>