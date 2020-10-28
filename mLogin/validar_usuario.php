<?php
session_name("sysAdMision");
session_start();
date_default_timezone_set('America/Monterrey');
include '../global_settings/conexion.php';
$p_user = $_POST['nombre_usuario'];
$p_contra = md5($_POST['pass']);

$consulta_usuario = "SELECT usuarios.id, 
							usuarios.nombre_usuario, 
							usuarios.id_persona, 
							usuarios.id_perfil, 
							CONCAT(personas.nombre,' ',personas.ap_paterno) AS 'Nombre Persona', 
							personas.id_sede, 
							usuarios.fecha, 
							personas.e_mail,
							personas.telefono
					FROM usuarios 
					INNER JOIN personas ON usuarios.id_persona = personas.id
						AND (usuarios.nombre_usuario='$p_user' or personas.num_empleado = '$p_user' AND personas.num_empleado is not null)
						AND usuarios.pass='$p_contra'
						AND usuarios.activo='1' 
						AND personas.activo='1'";


$usuario = mysqli_query($conexion, $consulta_usuario);
$row_usuario = mysqli_fetch_array($usuario);
$num_usuario = mysqli_num_rows($usuario);

if ($num_usuario==0) {
	echo "1";
}elseif ($num_usuario>0) {
	$cadena_perfil = "SELECT nombre FROM perfil WHERE id = '$row_usuario[3]'";
	$consulta_perfil = mysqli_query($conexion, $cadena_perfil);
	$row_perfil = mysqli_fetch_row($consulta_perfil);

	$cadena_sede = "SELECT nombre FROM sucursales WHERE id = '$row_usuario[5]'";
	$consulta_sede = mysqli_query($conexion, $cadena_sede);
	$row_sede = mysqli_fetch_row($consulta_perfil);

	$_SESSION["sysAdMision_id_usuario"] = $row_usuario[0];
	$_SESSION["sysAdMision_id_persona"] = $row_usuario[2];
	$_SESSION["sysAdMision_perfil"] = $row_usuario[3];
	$_SESSION["sysAdMision_persona"]= $row_usuario[4];
	$_SESSION["sysAdMision_sede"]= $row_usuario[5];
	$_SESSION["sysAdmision_nombre_perfil"]= $row_perfil[0];
	$_SESSION["sysAdMision_autenticado"] = "SI";
	$_SESSION["sysAdMision_ultimoAcceso"]= date("Y-n-j H:i:s");
	$_SESSION["sysAdMision_fechaAlta"] = $row_usuario[6];
	$_SESSION["sysAdMision_correo"] = $row_usuario[7];
	$_SESSION["sysAdMision_telefono"] = $row_usuario[8];
	$_SESSION["sysAdmision_nombreSede"] = $row_sede[0];

	echo "2";
}
 ?>
