<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d H:i:s"); 

$id = $_POST['id_registro'];
$cadena_liberar = "UPDATE faltantes_pasven SET estatus = '4', usuario_revisa = '$id_persona', fecha_revisa = '$fecha' WHERE id = '$id'";
$consulta_liberar = mysqli_query($conexion, $cadena_liberar);
echo "ok";
?>