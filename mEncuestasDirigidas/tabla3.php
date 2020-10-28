<?php
include '../global_seguridad/verificar_sesion.php';

$cadena_consulta = "SELECT id,folio,nombre FROM s_encuestas";
$consulta = mysqli_query($conexion, $cadena_consulta);
$cuerpo ="";
$numero = 1;
$boton_editar = "";
while ($row = mysqli_fetch_array($consulta)) {
	$boton_editar = "<button class='btn btn-warning' onclick='editar_registro($row[0])'>Editar</button>";
	$renglon = "
		{
		\"#\": \"$numero\",
		\"Nombre\": \"$row[1]\",
		\"Editar\": \"$boton_editar\"
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