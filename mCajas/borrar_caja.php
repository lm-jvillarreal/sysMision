<?php 
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');
	$id_caja = $_POST['id_caja'];
	$sql = "DELETE FROM cajas_articulos WHERE id = '$id_caja'";
	$exSql = mysqli_query($conexion, $sql);
	$sql2 = "DELETE FROM articulos_caja WHERE id_caja = '$id_caja'";
	$exSql2 = mysqli_query($conexion, $sql2);
 ?>