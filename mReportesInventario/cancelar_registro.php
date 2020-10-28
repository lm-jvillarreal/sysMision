<?php
include '../global_seguridad/verificar_sesion.php';

$id_registro = $_POST['id_libroDiario'];
$comentario = $_POST['comentario'];

$cadena_editar = "SELECT orden_compra FROM libro_diario WHERE id = '$id_registro'";
$consulta_oc = mysqli_query($conexion, $cadena_editar);
$row_oc = mysqli_fetch_array($consulta_oc);

$id_orden = $row_oc[0];

$cadena_update = "UPDATE orden_compra SET status = NULL, activo = '1', completo = '0', hora_inicio = NULL, hora_final = NULL, fecha_inicio = NULL, fecha_final = NULL, usuario_inicio = NULL, usuario_final = NULL, comentarios = NULL WHERE orden_compra = '$id_orden'";
$consulta_update = mysqli_query($conexion, $cadena_update);

$cadena_quemar = "UPDATE libro_diario SET activo = '5', comentario_cancela = '$comentario' WHERE id = '$id_registro'";
$consulta_quemar = mysqli_query($conexion, $cadena_quemar);
?>