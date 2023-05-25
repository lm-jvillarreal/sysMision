<?php
include '../global_seguridad/verificar_sesion.php';
$id_modulo = $_POST['id_modulo'];

$cadena_modulos = "SELECT activo FROM modulos WHERE id='$id_modulo'";
$consulta_modulos = mysqli_query($conexion, $cadena_modulos);
$row_modulos = mysqli_fetch_array($consulta_modulos);

if ($row_modulos[0]=='0') {
	$estado = '1';
}elseif($row_modulos[0]=='1'){
	$estado = '0';
}

$cadena_modifica = "UPDATE modulos SET activo = '$estado' WHERE id = '$id_modulo'";
$estatus_modulo = mysqli_query($conexion, $cadena_modifica);
$cadenaPermisos="UPDATE detalle_usuario SET activo='$estado' WHERE id_modulo='$id_modulo'";
$estatus_permiso =mysqli_query($conexion,$cadenaPermisos);
echo "ok";
?>