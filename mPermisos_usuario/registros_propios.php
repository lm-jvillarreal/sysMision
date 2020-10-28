<?php
include '../global_seguridad/verificar_sesion.php';
$id_registro = $_POST['id_registro'];

$cadena_verifica = "SELECT registros_propios FROM detalle_usuario WHERE id = '$id_registro'";
$consulta_verifica = mysqli_query($conexion, $cadena_verifica);
$row_verifica = mysqli_fetch_array($consulta_verifica);

if ($row_verifica[0]=='0') {
	$estado = '1';
}elseif($row_verifica[0]=='1'){
	$estado = '0';
}

$cadena_modifica = "UPDATE detalle_usuario SET registros_propios = '$estado' WHERE id = '$id_registro'";
$modifica_estado = mysqli_query($conexion, $cadena_modifica);

echo "ok";
?>