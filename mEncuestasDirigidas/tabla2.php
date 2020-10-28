<?php
include '../global_seguridad/verificar_sesion.php';

$filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
$cadena_consulta = "SELECT id,folio,nombre FROM s_encuestas WHERE activo = '1'".$filtro;
$consulta = mysqli_query($conexion, $cadena_consulta);
$cuerpo ="";
$numero = 1;
$boton_editar = "";
$boton_eliminar = "";
while ($row = mysqli_fetch_array($consulta)) {
	$boton_editar = "<button class='btn btn-warning' onclick='editar_registro($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";
	$boton_eliminar = "<button class='btn btn-danger' onclick='eliminar_encuesta($row[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
	$renglon = "
		{
		\"#\": \"$numero\",
		\"Nombre\": \"$row[2]\",
		\"Editar\": \"$boton_editar\",
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