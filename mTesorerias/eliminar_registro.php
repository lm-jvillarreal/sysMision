<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha =date('Y-m-d');
	$hora  =date('h:i:s');

	$folio = $_POST['folio'];

  	$qry = mysqli_query($conexion,"UPDATE faltantes SET activo = '0' WHERE folio = '$folio'");

  	echo "ok";
?>