<?php
include '../global_seguridad/verificar_sesion.php';

$id_encuesta = $_POST['id_encuesta'];

$cadena_consulta = "SELECT s_invitados.id,usuarios.id,
	CONCAT (personas.nombre,' ',personas.ap_paterno,' ', personas.ap_materno)
	FROM s_invitados
	INNER JOIN usuarios ON usuarios.id = s_invitados.id_usuario_resp
	INNER JOIN personas ON personas.id = usuarios.id_persona
	WHERE id_encuesta = '$id_encuesta'";
$consulta = mysqli_query($conexion, $cadena_consulta);
$cuerpo ="";
$numero = 1;
$boton_editar = "";
$boton_eliminar = "";
$boton_tipo = "";
while ($row = mysqli_fetch_array($consulta)) {
	$cadena_encuestas = mysqli_query($conexion,"SELECT s_respuestas.id
				FROM s_respuestas
				RIGHT JOIN s_preguntas ON  s_preguntas.id = s_respuestas.id_pregunta
				RIGHT JOIN s_encuestas ON  s_preguntas.folio = s_encuestas.id
				WHERE s_encuestas.id = '$id_encuesta' AND s_respuestas.id_usuario = '$row[1]'");
	$existe=mysqli_num_rows($cadena_encuestas);
	if($existe != 0){
		$boton_tipo = "<center><a href='#' data-id = '$numero' data-toggle = 'modal' data-target = '#modal-default1' target='blank'><span class='badge bg-green'>Ya Respondio</span></a></center> <input id='encuesta_resp$numero' value='$id_encuesta' class='hidden'> <input id='usuario_resp$numero' value='$row[1]' class='hidden'>";
	}else{
		$boton_tipo = "<center><span class='badge bg-red'>Sin Respuesta</span></center>";
	}
	$boton_editar = "<button class='btn btn-warning' onclick='editar_registro($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";
	$boton_eliminar = "<button class='btn btn-danger' onclick='eliminar_encuesta($row[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
	$renglon = "
		{
		\"#\": \"$numero\",
		\"Nombre\": \"$row[2]\",
		\"Encuesta\": \"$boton_tipo\"
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