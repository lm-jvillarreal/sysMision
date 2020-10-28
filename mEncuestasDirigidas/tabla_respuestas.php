<?php
include '../global_seguridad/verificar_sesion.php';

$id_encuesta = $_POST['id_encuesta'];
$id_usuario_resp = $_POST['id_usuario'];

$cadena_consulta = "SELECT s_preguntas.pregunta, respuesta 
					FROM s_respuestas 
					INNER JOIN s_preguntas ON s_preguntas.id = s_respuestas.id_pregunta
					WHERE s_preguntas.folio = '$id_encuesta' AND s_respuestas.id_usuario = '$id_usuario_resp'";

$consulta = mysqli_query($conexion, $cadena_consulta);
$cuerpo = "";
$numero = 1;
while ($row_preguntas = mysqli_fetch_array($consulta)) {
	$renglon = "
		{
		\"#\": \"$numero\",
		\"Pregunta\": \"$row_preguntas[0]\",
		\"Respuesta\": \"$row_preguntas[1]\"
		},";
	$cuerpo = $cuerpo.$renglon;
	$numero ++;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>