<?php
	include '../global_settings/conexion.php';
	$ide = $_GET['ide'];
	
	$cadena_equipo= "SELECT id_tipo FROM tipos_equipos WHERE activo = '1'";
	$consulta_equipo= mysqli_query($conexion, $cadena_equipo);
	$row_equipo = mysqli_fetch_array($consulta_equipo);


	$cadena= "SELECT
				dc.id 
  			FROM
				detalle_caja dc
			INNER JOIN tipos_equipos te ON dc.id_equipo = te.id_tipo 
  			WHERE
				dc.activo = '1' 
			AND dc.id_caja= '$ide'
			and dc.id_equipo = $row_equipo[0]";
	$consulta = mysqli_query($conexion, $cadena);
	$row_cadena= mysqli_fetch_array($consulta);
	
	$array = array(
		$row_cadena[0]
	);
	$array_datos = json_encode($array);
	echo $cadena;
?>