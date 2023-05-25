<?php
include '../global_seguridad/verificar_sesion.php';
$id_modulo = $_POST['modulo'];
$id_categoria = $_POST['categoria'];

$cadena_modulo = "UPDATE modulos SET categoria = '$id_categoria' WHERE id = '$id_modulo'";
$consulta_modulo = mysqli_query($conexion, $cadena_modulo);

$cadena_detalle = "UPDATE detalle_usuario SET id_categoria = '$id_categoria' WHERE id_modulo = '$id_modulo'";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
echo "ok";
?>