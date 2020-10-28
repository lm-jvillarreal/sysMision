<?php
include '../global_seguridad/verificar_sesion.php';

$id_codigo = $_POST['id_codigo'];
$comentario = $_POST['observacion'];

$cadenaComenta = "UPDATE auditoria_pv SET codigo_comentario = '$comentario' WHERE id = '$id_codigo'";
$consultaComenta = mysqli_query($conexion, $cadenaComenta);
echo "ok";
?>