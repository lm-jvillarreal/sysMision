<?php
include '../global_seguridad/verificar_sesion.php';
$id = $_POST['id_auditoria'];
$comentario = $_POST['coment_auditoria'];

$cadena_actualizar = "UPDATE auditoria_libroDiario SET comentario_autoriza = '$comentario' WHERE id = '$id'";
$consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
echo "ok";
?>