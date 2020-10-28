<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d H:i:s"); 

$id = $_POST['id'];
$comentario = $_POST['comentario'];
$cadena_liberar = "UPDATE faltantes_pasven SET estatus = '4', usuario_verifica = '$id_persona', fecha_verifica = '$fecha', comenta_verifica = '$comentario' WHERE id = '$id'";
$consulta_liberar = mysqli_query($conexion, $cadena_liberar);
echo "ok";
?>