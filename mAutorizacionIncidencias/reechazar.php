<?php
	include '../global_seguridad/verificar_sesion.php';
	$id_registroo = $_POST['id_registroo'];
	$comentario_final=$_POST['comentario_final'];

	

	$cadena_modifica = "UPDATE incidencias SET comentario_fin='$comentario_final', folio = '2' WHERE id = '$id_registroo'";

	$actualizar = mysqli_query ($conexion, $cadena_modifica);
 	echo "ok";
 ?>