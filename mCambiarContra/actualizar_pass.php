<?php
include '../global_seguridad/verificar_sesion.php';

$nueva_contra = md5($_POST['nueva_contra']);

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$cadena_actualizar = "UPDATE usuarios SET pass = '$nueva_contra', hora='$hora', activo='1', usuario= '$id_usuario' WHERE id = '$id_usuario'";

$actualizar_pass = mysqli_query($conexion, $cadena_actualizar);

echo "ok";
?>
