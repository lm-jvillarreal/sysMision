<?php
	include '../global_seguridad/verificar_sesion.php';
	$id_registro = $_POST['id_registro'];
	$decision=$_POST['decision'];
	$comentario_fin=$_POST['comentario_fin'];

	$cadena_modifica = "UPDATE incidencias SET decision ='$decision', comentario_fin='$comentario_fin', folio='1' WHERE id = '$id_registro'";

	$actualizar = mysqli_query ($conexion, $cadena_modifica);
 	echo "ok";
 ?>