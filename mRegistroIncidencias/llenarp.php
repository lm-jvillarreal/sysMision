<?php
	include '../global_seguridad/verificar_sesion.php';
 
	$id_promotor= $_POST['id_promotor'];

$cadena_consulta="SELECT compañia, concat(nombre,' ',ap_paterno) FROM promotores WHERE activo='1' AND id= '$id_promotor'";

	$cadena_compañia = mysqli_query($conexion, $cadena_consulta);

$row_compañia=mysqli_fetch_array($cadena_compañia);
	$array=array(
	$row_compañia[0],
	$row_compañia[1]);//accion
	$array_datos = json_encode($array);
	echo $array_datos;
	
	
?>
