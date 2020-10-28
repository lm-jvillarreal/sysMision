<?php
include '../global_seguridad/verificar_sesion.php';

$max = mysqli_query($conexion,"SELECT MAX(folio) FROM n_encuestas");
$row = mysqli_fetch_array($max);

$cadena_consulta = "SELECT id,pregunta,CASE
                tipo 
                WHEN '1' THEN
                'Cualitativo' 
                WHEN '2' THEN
                'Cuantitativo' 
                WHEN '3' THEN 
                'Libre'
                ELSE 'Especial'
              END AS tipo FROM n_preguntas WHERE folio = '$row[0]'";
$consulta = mysqli_query($conexion, $cadena_consulta);
$cuerpo ="";
$numero = 1;
$modal= "";
while ($row_preguntas = mysqli_fetch_array($consulta)) {
	if($row_preguntas[2] == "Especial"){
		$modal = "<a href='#' data-id = '$row_preguntas[0]' data-toggle = 'modal' data-target = '#modal-default3' target='blank' class='btn btn-danger'><span>+ Respuestas</span></a>";
	}else{
		$modal = "";
	}
	$renglon = "
		{
		\"#\": \"$numero\",
		\"Nombre\": \"$row_preguntas[1]\",
		\"Tipo\": \"$row_preguntas[2]\",
		\"Respuestas\": \"$modal\"
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