<?php 
	include '../global_settings/conexion.php';
	$tipo = $_POST['tipo'];
	$comentarios = $_POST['comentario'];
	if ($tipo == 1) {
		$sql = "UPDATE comentarios_reportes SET comentarios_diestel = '$comentarios'";
	}else{
		$sql = "UPDATE comentarios_reportes SET comentarios_immex = '$comentarios'";
	}
	echo "$sql";
	$exSql = mysqli_query($conexion, $sql);
	

 ?>