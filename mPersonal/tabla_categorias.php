<?php
include '../global_seguridad/verificar_sesion.php';
$cadena_usuarios = "SELECT
						personas.id,
						CONCAT(personas.nombre,' ', personas.ap_paterno,' ',ap_materno),
						usuarios.nombre_usuario, 
						perfil.nombre,
						usuarios.activo,
						usuarios.id,
						(SELECT nombre FROM sucursales where id=personas.id_sede)
					FROM
						personas
						INNER JOIN usuarios ON personas.id = usuarios.id_persona
						INNER JOIN perfil ON usuarios.id_perfil = perfil.id";

$consulta_usuarios = mysqli_query($conexion, $cadena_usuarios);

$cuerpo = "";
while ($row_usuarios = mysqli_fetch_array($consulta_usuarios)) {

	if(file_exists("../d_plantilla/dist/img/personas/".$row_usuarios[5].".jpg")){
		$imagen_usuario = $row_usuarios[5].".jpg";
	}else{
		$imagen_usuario = "user.jpg";
	}

	$activo = ($row_usuarios[4]=="0") ? "" : "checked";
	$editar = "<center><a href='#' onclick='editar($row_usuarios[0])'>$row_usuarios[0]</a></center>";
	$chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_usuarios[0])'></center>";
	$restaurar = "<center><a href='#' class='btn btn-danger' onclick='restaurar($row_usuarios[5])'><i class='fa fa-refresh' aria-hidden='true'></i></a></center>";
  $nom_usuario = "<div class='input-group' style='width:100%''><input type='text' id='usr_$row_usuarios[5]' class='form-control' value='$row_usuarios[2]'><span class='input-group-btn'><button onclick='cambia_usuario($row_usuarios[5])' class='btn btn-danger' type='button'><i class='fa fa-floppy-o fa-lg' aria-hidden='true'></i></button></span></div>";

	$people = "<img src='../d_plantilla/dist/img/personas/$imagen_usuario' class='img-circle' width='15%'>$row_usuarios[1]";
	$renglon = "
	{
		\"id\": \"$editar\",
		\"persona\": \"$people\",
		\"sucursal\": \"$row_usuarios[6]\",
		\"user\": \"$row_usuarios[2]\",
		\"usuario\": \"$nom_usuario\",
		\"perfil\": \"$row_usuarios[3]\",
		\"pass\": \"$restaurar\",
		\"activo\": \"$chk_activo\"
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