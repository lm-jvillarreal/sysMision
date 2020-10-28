<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d H:i:s"); 

$id = $_POST['id'];
$id_comprador = $_POST['id_comprador'];
$cadena_liberar = "UPDATE faltantes_pasven SET id_comprador = '$id_comprador' WHERE id = '$id'";
$consulta_liberar = mysqli_query($conexion, $cadena_liberar);
echo "ok";
?>