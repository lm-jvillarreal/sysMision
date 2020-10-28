<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');

	$id_encuesta = $_POST['id_encuesta'];
	$fecha1      = $_POST['fecha1'];
	$fecha2      = $_POST['fecha2'];
	$pregunta    = $_POST['pregunta'];

	$filtro = ($pregunta != "")?" AND n_preguntas.id = $pregunta":"";

	$consulta = mysqli_query($conexion,"SELECT n_resultados.respuesta,n_preguntas.pregunta
                FROM n_resultados
                INNER JOIN n_preguntas ON n_preguntas.id = n_resultados.id_pregunta
                WHERE n_preguntas.tipo = '3'
                ".$filtro."
                AND n_resultados.folio_encuesta = '$id_encuesta'
                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE)
                AND CAST('$fecha2' AS DATE)");
	$cuerpo ="";
	$numero = 1;
	while ($row = mysqli_fetch_array($consulta)) 
	{	
		$renglon = "
			{
			\"#\": \"$numero\",
			\"Pregunta\": \"$row[1]\",
			\"Respuesta\": \"$row[0]\"
			},";
		$cuerpo = $cuerpo.$renglon;
		$numero ++;
	}
	$cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
	$tabla = "
	["
	.$cuerpo2.
	"]
	";
	echo $tabla;
?>