<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
$datos=array();
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$cadena_modulos = "SELECT id, 
													nombre, 
													descripcion,
													CONCAT('http://200.1.1.178/sysMision/',nombre_carpeta),
													(SELECT nombre FROM categorias_modulos WHERE id=modulos.categoria),
													activo
										FROM modulos order by id asc";
$consulta_modulos = mysqli_query($conexion, $cadena_modulos);

while ($row_modulos = mysqli_fetch_array($consulta_modulos)) {
	$activo = ($row_modulos[5]=="0") ? "" : "checked";
	$chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='activo($row_modulos[0])'></center>";
	$link = "<center><a href='#' onclick='baja($row_modulos[0])'class='btn btn-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></center>";
	$desc_modulo=mysqli_real_escape_string($conexion,$row_modulos[2]);
	$ruta="<a href='$row_modulos[3]' target='_blank'>$row_modulos[3]</a>";
	
	array_push($datos,array(
		'id_modulo'=>$row_modulos[0],
		'nombre_modulo'=>$row_modulos[1],
		'categoria'=>$row_modulos[4],
		'desc_modulo'=>$desc_modulo,
		'ruta'=>$ruta,
		'editar_modulo'=>$link,
		'opciones'=>$chk_activo
	));
}
echo utf8_encode(json_encode($datos));
?>