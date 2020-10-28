<?php 
	include '../global_settings/conexion.php';
	$pId = $_POST['id_nota'];
	$sql = "UPDATE notas_entrada SET diferencia_restante = 0, concepto = 'Descuento general' WHERE id = '$pId'";
	echo "$sql";
	$exSql = mysqli_query($conexion, $sql);

 ?>