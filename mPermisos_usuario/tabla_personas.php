<?php
include '../global_seguridad/verificar_sesion.php';

$ide_perfil = $_POST['ide_perfil'];
$cadena_consulta = "SELECT p.id, u.id, CONCAT(p.nombre,' ',p.ap_paterno, ' ',p.ap_materno), u.nombre_usuario
FROM personas as p 
INNER JOIN usuarios as u ON p.id = u.id_persona AND u.activo = '1'
AND u.id_perfil = '$ide_perfil'";

$consulta_personas = mysqli_query($conexion, $cadena_consulta);

$cuerpo = "";
while ($row_personas = mysqli_fetch_array($consulta_personas)) {
	$seleccionar="<center><button class='btn btn-danger' onclick='cargar_tabla_modulos($row_personas[1])'><i class='fa fa-wrench' aria-hidden='true'></i></button></center>";
	$renglon = "
	{
		\"id\": \"$row_personas[0]\",
		\"persona\": \"$row_personas[2]\",
		\"usuario\": \"$row_personas[3]\",
	    \"seleccionar\": \"$seleccionar\"
	  },";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>