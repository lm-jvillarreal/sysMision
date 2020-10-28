<?php
include '../global_seguridad/verificar_sesion.php';
$id_registro = $_POST['id_registro'];

$cadena_modifica = "DELETE FROM detalle_usuario WHERE id = '$id_registro'";
$modifica_estado = mysqli_query($conexion, $cadena_modifica);

echo "ok";
?>