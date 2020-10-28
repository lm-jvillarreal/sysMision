<?php
include '../global_settings/conexion.php';
	$cadena_pacientes = "SELECT
											pacientes.id,
											CONCAT( pacientes.nombre, ' ', pacientes.ap_paterno, ' ', pacientes.ap_materno ),
											pacientes.sexo, 
											DATE_FORMAT(pacientes.fecha_nacimiento,'%d/%m/%Y'),
											pacientes.fecha_nacimiento,
											pacientes.desc_alergia
										FROM
											pacientes";
						
	//Restricción para una sola verificación
	//AND lista_proyectos.verificado='0'
 //echo $cadena_modulos;
 $consulta_pacientes = mysqli_query($conexion, $cadena_pacientes);
 $cuerpo = "";
while ($row_pacientes = mysqli_fetch_array($consulta_pacientes)) {

	$cumpleanos = new DateTime($row_pacientes[4]);
	$hoy = new DateTime();
	$annos = $hoy->diff($cumpleanos);
	$edad = $annos->y." años";

	$editar= "<center><a onclick='editar_registro($row_pacientes[0])' class='btn btn-warning text-center'><i class='fa fa-edit'></i></a></center>";
	$eliminar= "<button onclick='eliminar($row_pacientes[0]);' type='button' class='btn btn-danger btn-s remove-item'><i class='fa fa-times'></i></button>";
	$consulta= "<a href='consulta.php?id_paciente=$row_pacientes[0]' class='btn btn-primary text-center'>Consulta</a>";
	$renglon = "
	{
		\"id\": \"$row_pacientes[0]\",
		\"nombre_completo\": \"$row_pacientes[1]\",
		\"sexo\": \"$row_pacientes[2]\",
		\"fecha_nacimiento\": \"$row_pacientes[3]\",
		\"edad\": \"$edad\",
		\"desc_alergia\": \"$row_pacientes[5]\",
		\"editar\": \"$editar\",
		\"eliminar\": \"$eliminar\",
		\"consulta\": \"$consulta\"
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