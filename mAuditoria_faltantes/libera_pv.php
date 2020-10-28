<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d H:i:s"); 
$hora=date ("h:i:s");

$id_registro = $_POST['id_registro'];
$comentario = $_POST['comentario'];

$cadena_libera = "UPDATE faltantes_pasven SET estatus = '8', comentario_auditor = '$comentario', fecha_audita = '$fecha', usuario_auditor = '$id_usuario' WHERE id = '$id_registro'";
$libera_pv = mysqli_query($conexion, $cadena_libera);

echo "ok";
?>