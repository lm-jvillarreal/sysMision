<?php
	include '../global_seguridad/verificar_sesion.php';
	$id_registro = $_POST['id_registro'];
	$decision=$_POST['decision'];
	$comentario_fin=$_POST['comentario_fin'];

	$cadena_modifica = "UPDATE incidencias SET comentario_fin='$comentario_fin', folio='2', usuario='$id_usuario', fecha_aut_can='$fecha', perfil = '2' WHERE id = '$id_registro'";

	$actualizar = mysqli_query ($conexion, $cadena_modifica);
 	echo "ok";
 ?>