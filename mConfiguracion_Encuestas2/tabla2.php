<?php
include '../global_seguridad/verificar_sesion.php';

$filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";

$cadena_consulta = "SELECT folio,nombre FROM n_encuestas WHERE activo = '1'".$filtro;
$consulta = mysqli_query($conexion, $cadena_consulta);
$cuerpo ="";
$numero = 1;
$modal = "";
while ($row_preguntas = mysqli_fetch_array($consulta)) {
	$modal = "<a href='#' data-id = '$row_preguntas[0]' data-toggle = 'modal' data-target = '#modal-default' target='blank' class='btn btn-danger'><span>Ver Encuesta</span></a>";
	$eliminar = "<button class='btn btn-danger' onclick='eliminar_encuesta($row_preguntas[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
	$renglon = "
		{
		\"#\": \"$numero\",
		\"Nombre\": \"$row_preguntas[1]\",
		\"Ver\": \"$modal\",
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