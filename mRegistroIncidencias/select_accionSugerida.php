<?php
	include '../global_seguridad/verificar_sesion.php';
 
	$incidencia= $_POST['incidencia'];

$cadena_consulta="SELECT si.id,si.nombre, si.activo FROM sanciones_incidencias si INNER JOIN catalogo_incidencias ci on ci.accion_sugerida=si.id and si.activo='1' AND ci.id= '$incidencia'";

	$cadena_accion = mysqli_query($conexion, $cadena_consulta);

$row_accion=mysqli_fetch_array($cadena_accion);
	$array=array(
	$row_accion[0],//id_sancion	
	$row_accion[1],//sancion
	$row_accion[2]);//accion
	$array_datos = json_encode($array);
	echo $array_datos;
	
	
?>
