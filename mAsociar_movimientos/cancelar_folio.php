<?php
include '../global_seguridad/verificar_sesion.php';
$id_folio = $_POST['id_folio'];
$comentario = $_POST['comentario'];

$cadena_cancelar = "UPDATE formatos_movimientos SET estatus = '3', comentario_cancela = '$comentario', usuario_cancela = '$id_usuario' WHERE id = '$id_folio'";
$cancela_folio = mysqli_query($conexion, $cadena_cancelar);
echo "ok";
?>