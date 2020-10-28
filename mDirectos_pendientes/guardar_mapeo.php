<?php 
include '../global_seguridad/verificar_sesion.php';
	$pId_mapeo = $_POST['id_mapeo'];
	$qry = "UPDATE inv_mapeo SET completo = 1, activo = 0 WHERE id = '$pId_mapeo'";
	echo "$qry";
	$exQry = mysqli_query($conexion, $qry);
	
 ?>