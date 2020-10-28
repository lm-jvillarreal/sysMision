<?php
include '../global_seguridad/verificar_sesion.php';
$id_perfil = $_POST['id_perfil'];
$id_modulos = $_POST['modulos'];
$long  = count($id_modulos);

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$cadena_valida = "SELECT * FROM detalle_perfil WHERE id_perfil = '$id_perfil' AND (id_modulo = '2' OR id_modulo = '4' OR id_modulo = '39' OR id_modulo = '44')";
$consulta_valida = mysqli_query($conexion, $cadena_valida);
$conteo = mysqli_num_rows($consulta_valida);

if ($conteo==0) {
	$cadena_pc = "INSERT INTO detalle_perfil (id_perfil, id_modulo, fecha, hora, activo, usuario)VALUES('$id_perfil', '2', '$fecha', '$hora', '1', '$id_usuario')";
	$insertar_pc = mysqli_query($conexion, $cadena_pc);

	$cadena_cp = "INSERT INTO detalle_perfil (id_perfil, id_modulo, fecha, hora, activo, usuario)VALUES('$id_perfil', '4', '$fecha', '$hora', '1', '$id_usuario')";
	$insertar_cp = mysqli_query($conexion, $cadena_cp);

	$cadena_ap = "INSERT INTO detalle_perfil (id_perfil, id_modulo, fecha, hora, activo, usuario)VALUES('$id_perfil', '39', '$fecha', '$hora', '1', '$id_usuario')";
	$insertar_ap = mysqli_query($conexion, $cadena_ap);

	$cadena_md = "INSERT INTO detalle_perfil (id_perfil, id_modulo, fecha, hora, activo, usuario)VALUES('$id_perfil', '44', '$fecha', '$hora', '1', '$id_usuario')";
	$insertar_md = mysqli_query($conexion, $cadena_md);
}
for ($i=0; $i < $long ; $i++) { 
	$cadena_insertar = "INSERT INTO detalle_perfil (id_perfil, id_modulo, fecha, hora, activo, usuario)VALUES('$id_perfil','$id_modulos[$i]', '$fecha', '$hora', '1', '$id_usuario')";
	$insertar_detalle = mysqli_query($conexion, $cadena_insertar);
}
//Todos los usuarios que coincidan con el perfil
$cadena_usuarios = "SELECT id FROM usuarios WHERE id_perfil = '$id_perfil'";
$consulta_usuarios = mysqli_query($conexion, $cadena_usuarios);

while ($row_usuarios = mysqli_fetch_array($consulta_usuarios)) {
	for ($i=0; $i < $long ; $i++) {
		
		$cadena_categoria = "SELECT categoria FROM modulos WHERE id = $id_modulos[$i]";
		$consulta_categoria = mysqli_query($conexion, $cadena_categoria);
		$row_categoria = mysqli_fetch_array($consulta_categoria);

		$cadena_insertar_du = "INSERT IGNORE INTO detalle_usuario(id_usuario, id_modulo, id_categoria, fecha, hora, activo, usuario)VALUES('$row_usuarios[0]','$id_modulos[$i]','$row_categoria[0]','$fecha','$hora','1','$id_usuario')";

		$insertar_detalle_usuario = mysqli_query($conexion, $cadena_insertar_du);
	}
}
echo "ok";
 ?>