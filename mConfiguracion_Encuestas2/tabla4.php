<?php
include '../global_seguridad/verificar_sesion.php';

$id_pregunta = $_POST['id_pregunta'];

$cadena_consulta = "SELECT id,respuesta FROM n_respuestas WHERE id_pregunta = '$id_pregunta' AND activo = '1'";
$consulta = mysqli_query($conexion, $cadena_consulta);
$cuerpo ="";
$numero = 1;
while ($row = mysqli_fetch_array($consulta)) {
	$eliminar = "<button class='btn btn-danger' onclick='eliminar_respuesta($row[0],$id_pregunta)'>Eliminar</button>";
	$renglon = "
		{
		\"#\": \"$numero\",
		\"Nombre\": \"$row[1]\",
		\"Eliminar\": \"$eliminar\"
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