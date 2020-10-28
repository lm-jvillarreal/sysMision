<?php 
include '../global_settings/conexion.php';
	$cadena_medicos = "SELECT
						medicos.id,
						(SELECT  CONCAT (nombre,' ', ap_paterno,' ', ap_materno) FROM personas WHERE personas.id = medicos.id_persona),
						medicos.cedula, 
						medicos.instituciones,
			            medicos.especialidad
					FROM
						medicos";
						
	//Restricción para una sola verificación
	//AND lista_proyectos.verificado='0'
 //echo $cadena_modulos;
 $consulta_medicos = mysqli_query($conexion, $cadena_medicos);
 $cuerpo = "";
 
while ($row_medicos = mysqli_fetch_array($consulta_medicos)) {
	$editar= "<a onclick='editar_registro($row_medicos[0])' class='btn btn-warning text-center'>Editar</a>";

    $eliminar= "<button onclick='eliminar($row_medicos[0]);' type='button' class='btn btn-danger btn-s remove-item'><i class='fa fa-times'></i></button>";

	$renglon = "
	{
		\"id\": \"$row_medicos[0]\",
		\"id_persona\": \"$row_medicos[1]\",
		\"cedula\": \"$row_medicos[2]\",
	    \"instituciones\": \"$row_medicos[3]\",
	    \"especialidad\": \"$row_medicos[4]\",
	    \"editar\": \"$editar\",
	    \"eliminar\": \"$eliminar\"
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