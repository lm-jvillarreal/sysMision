<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];
$cadena_elimina = "DELETE FROM faltantes_pasven WHERE id = '$id'";
$consulta_elimina = mysqli_query($conexion, $cadena_elimina);
echo "ok";
?>