<?php 
	include '../global_settings/conexion.php';
	$tipo_mov = $_POST['tipo_mov'];
	$folio_mov = $_POST['folio_mov'];
	$sucursal = $_POST['sucursal'];
	$ctb_usuario = $_POST['ctb_usuario'];
	$comentarios = $_POST['comentarios'];
	$nombre = $_POST['autoriza'];
	$usuario = $_POST['usuario'];
	$variable;
	$call = "CALL sp_valida_inserta('$folio_mov', '$tipo_mov', '$sucursal', '$ctb_usuario', '$comentarios', '$nombre', @respuesta)";
	$exCall = mysqli_query($conexion, $call);
	$s = "SELECT @respuesta as sp_valida";
	$exS = mysqli_query($conexion, $s);
	$row = mysqli_fetch_row($exS);
	echo "$row[0]";


 ?>