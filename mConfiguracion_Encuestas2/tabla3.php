<?php
include '../global_seguridad/verificar_sesion.php';

$id_encuesta = $_POST['id_encuesta'];

$cadena_consulta = "SELECT id, codigo_trabajador,id_encuesta,sucursal,departamento FROM n_invitados WHERE activo = '1' AND id_encuesta = '$id_encuesta'";
$consulta = mysqli_query($conexion, $cadena_consulta);
$cuerpo ="";
$numero = 1;
$modal = "";

while ($row = mysqli_fetch_array($consulta)) {
	$cadena2 = mysqli_query($conexion,"SELECT nombre_completo FROM trabajadores_sql WHERE codigo = '$row[1]'");
	$row2 = mysqli_fetch_array($cadena2);

	$cadena3 = mysqli_query($conexion,"SELECT id FROM n_resultados WHERE folio_encuesta = '$id_encuesta' AND id_persona = '$row[1]'");
	$existe = mysqli_num_rows($cadena3);
	if($existe == 0){
		$modal = "<a href='#' data-id = '$numero' data-toggle = 'modal' data-target = '#modal-default2' target='blank' class='btn btn-danger'><i class='fa fa-file-text fa-lg'></i></a> <input type='hidden' id='trabajador$numero' value='$row[1]'> <input type='hidden' id='encuesta$numero' value='$row[2]'>";
	}else{
		$modal = "<button class='btn btn-success'><i class='fa fa-check-square fa-lg'></i></button>";
	}

	
	$renglon = "
		{
		\"#\": \"$numero\",
		\"Nombre\": \"$row2[0]\",
		\"Ver\": \"$modal\"
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