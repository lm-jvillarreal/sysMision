<?php
include '../global_seguridad/verificar_sesion.php';
$id_registro = $_POST['id_registro'];

$cadena_verifica = "SELECT activo FROM categorias_modulos WHERE id = '$id_registro'";
$consulta_verifica = mysqli_query($conexion, $cadena_verifica);
$row_verifica = mysqli_fetch_array($consulta_verifica);

if ($row_verifica[0]=='0') {
	$estado = '1';
}elseif($row_verifica[0]=='1'){
	$estado = '0';
}

$cadena_modifica = "UPDATE categorias_modulos SET activo = '$estado' WHERE id = '$id_registro'";
$modifica_estado = mysqli_query($conexion, $cadena_modifica);

echo "ok";
?>