<?php 
		
	include '../global_settings/conexion_supsys.php';
	//include'../global_seguridad/verificar_sesion.php';
	$s_idUsuario = $_SESSION["s_IdUser"];
	$s_idPerfil = $_SESSION["sTipoUsuario"];
	date_default_timezone_set("America/Monterrey");
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');
	$nombre = $_POST['nombre'];
	$sql = "INSERT INTO catalogos_pedidos (nombre, id_area, activo) VALUES ('$nombre', 1, 1)";
	$exSql = mysqli_query($conexion, $sql);
 ?>