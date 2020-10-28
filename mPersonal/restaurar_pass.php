<?php
include '../global_seguridad/verificar_sesion.php';
$id_registro = $_POST['id_registro'];
$pass = MD5("123456789");
$cadena_restaura = "UPDATE usuarios SET pass = '$pass' WHERE id = '$id_registro'";

$consulta_restaura = mysqli_query($conexion, $cadena_restaura);

echo "ok";
?>