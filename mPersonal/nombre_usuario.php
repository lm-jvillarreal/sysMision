<?php
include '../global_seguridad/verificar_sesion.php';
$usuario = $_POST['usuario'];
$id_usuario = $_POST['id_usuario'];

$cadena_actualizar = "UPDATE usuarios SET nombre_usuario = '$usuario' WHERE id = '$id_usuario'";
$actualizar_usuario = mysqli_query($conexion, $cadena_actualizar);
echo "ok";
?>