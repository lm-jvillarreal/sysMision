<?php
include '../global_seguridad/verificar_sesion.php';
$id = $_POST['id'];
$costo = $_POST['costo'];
$comentario = $_POST['comentario'];

$cadena_actualiza = "UPDATE costos_cero SET costo='$costo', comentario='$comentario', id_resuelve='$id_usuario', estatus='2' WHERE id = '$id'";
$actualiza_codigo = mysqli_query($conexion, $cadena_actualiza);
echo "ok";
?>