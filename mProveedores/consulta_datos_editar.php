<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];

$cadena_consulta = "SELECT id, 
														numero_proveedor, 
														proveedor, 
														correo_vendedor,
														id_comprador,
														(SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) FROM personas INNER JOIN usuarios ON personas.id=usuarios.id_persona WHERE usuarios.id = proveedores.id_comprador),
														tipo_proveedor,
														(SELECT TIPO_PROVEEDOR FROM categorias_proveedor WHERE ID=proveedores.tipo_proveedor),
														dificultad
										FROM proveedores WHERE id = '$id'";
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
	$row_editar[8]
);
$array_datos = json_encode($array);
echo $array_datos;
?>