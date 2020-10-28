<?php
	include '../global_settings/conexion.php';
	$cadena_encuestas = "SELECT id,nombre,folio FROM cuestionarios WHERE activo = '1' GROUP BY folio ";
	$consulta_encuestas = mysqli_query($conexion, $cadena_encuestas);
	 $opciones = "<option selected></option>";
	while ($row_encuestas = mysqli_fetch_row($consulta_encuestas)) {
			$opciones .= "<option value='$row_encuestas[2]'>$row_encuestas[1]</option>";
  	}
  	echo $opciones;
?>