<?php 
	error_reporting(E_ALL ^ E_NOTICE);
	session_name("login_supsys");
	session_start();
	$sucursal = $_SESSION["s_Sucursal"];
	include '../configuracion/conexion_servidor.php';
	include '../global_settings/conexion.php';
	date_default_timezone_set("America/Monterrey");
	$id = $_POST['id'];
	$sql = "DELETE FROM notas_entrada WHERE id = '$id'";
	echo "$sucursal";
	$exSql = mysqli_query($conexion, $sql);
 ?>