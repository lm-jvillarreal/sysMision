<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_promotor = $_POST['id_promotor'];
	$comentario  = $_POST['comentario'];

	$cadena = mysqli_query($conexion,"UPDATE registro_entrada SET comentario = '$comentario', fecha = '$fecha', hora_salida = '$hora' WHERE id_promotor = '$id_promotor' AND fecha = '$fecha' AND id_sucursal = '$id_sede'");
	$cadena2 = mysqli_query($conexion,"UPDATE agenda_promotores SET activo = '2' WHERE id_promotor = '$id_promotor' AND dia = '$fecha' AND id_sucursal = '$id_sede'");
	echo 'ok';
?>
