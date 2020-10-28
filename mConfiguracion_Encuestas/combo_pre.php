<?php
	include '../global_settings/conexion.php';
	$folio = $_POST['folio'];
	$cadena_encuestas = "SELECT p.id,p.pregunta
              FROM
                encuestas e
              INNER JOIN preguntas p ON p.id = e.id_pregunta
              WHERE
                e.folio_cuestionario = '$folio'";
	$consulta_encuestas = mysqli_query($conexion, $cadena_encuestas);
	 $opciones = "<option selected></option>";
	while ($row_encuestas = mysqli_fetch_row($consulta_encuestas)) {
			$opciones .= "<option value='$row_encuestas[0]'>$row_encuestas[1]</option>";
  	}
  	echo $opciones;
?>