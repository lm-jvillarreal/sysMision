<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];

$cadena_consulta = "SELECT
						personas.id,
						personas.nombre, 
						personas.ap_paterno, 
						personas.ap_materno,
						usuarios.nombre_usuario, 
						perfil.nombre,
						usuarios.activo,
						usuarios.id,
						usuarios.id_perfil,
						personas.id_sede,
						sucursales.nombre
					FROM
						personas
						INNER JOIN usuarios ON personas.id = usuarios.id_persona
						INNER JOIN perfil ON usuarios.id_perfil = perfil.id
						INNER JOIN sucursales ON personas.id_sede = sucursales.id AND personas.id='$id'";
$consulta_editar = mysqli_query($conexion, $cadena_consulta);

$row_editar = mysqli_fetch_array($consulta_editar);

$array = array(
	$row_editar[0],
	$row_editar[1],
	$row_editar[2],
	$row_editar[3],
	$row_editar[4],
	$row_editar[5],
	$row_editar[6],
	$row_editar[7],
	$row_editar[8],
	$row_editar[9],
	$row_editar[10]
);
$array_datos = json_encode($array);
echo $array_datos;
?>