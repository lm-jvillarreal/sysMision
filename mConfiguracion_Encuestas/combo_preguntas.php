<?php
	include '../global_settings/conexion.php';
	$cadena_preguntas = "SELECT id, pregunta FROM preguntas WHERE activo = '1' GROUP BY folio";
	$consulta_preguntas = mysqli_query($conexion, $cadena_preguntas);
	 
	while ($row_preguntas = mysqli_fetch_row($consulta_preguntas)) {
			echo "<option value='$row_preguntas[0]'>$row_preguntas[1]</option>";
  	}
?>