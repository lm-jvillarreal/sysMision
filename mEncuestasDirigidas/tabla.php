<?php
include '../global_seguridad/verificar_sesion.php';

$folio_encuesta = $_POST['folio_encuesta'];

$cadena_consulta = "SELECT id,pregunta FROM s_preguntas WHERE folio = '$folio_encuesta' AND activo = '1'";
$consulta = mysqli_query($conexion, $cadena_consulta);
$cuerpo ="";
$numero = 1;
while ($row_preguntas = mysqli_fetch_array($consulta)) {
	$boton_eliminar = "<button class='btn btn-danger' onclick='eliminar_pregunta($row_preguntas[0])'>Eliminar</button>";
	$pregunta = "<label ondblclick='ver($numero)'>$row_preguntas[1]</label><input class='form-control hidden' value='$row_preguntas[1]' id='pregunta$numero' onkeyup='if(event.keyCode == 13)actualizar_pregunta($row_preguntas[0],this.value)'>";
	$renglon = "
		{
		\"#\": \"$numero\",
		\"Nombre\": \"$pregunta\",
		\"Eliminar\": \"$boton_eliminar\"
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