<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha=date('Y-m-d');
	$hora=date('h:i:s');

	$folio = $_POST['folio'];

  	$qry = mysqli_query($conexion,"UPDATE efectivos SET activo = '0' WHERE folio = '$folio'");
  	$qry_otros = mysqli_query($conexion,"UPDATE otros SET activo = '0' WHERE folio = '$folio'");

  	echo "ok";
?>