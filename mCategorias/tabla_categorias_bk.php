<?php
include '../global_seguridad/verificar_sesion.php';

$cadena_consulta = "SELECT id, nombre, descripcion, activo FROM categorias_modulos";
$consulta_categorias = mysqli_query($conexion, $cadena_consulta);
$cuerpo ="";
while ($row_categorias = mysqli_fetch_array($consulta_categorias)) {
	$activo = ($row_categorias[3]=="0") ? "" : "checked";
	$link_editar = "<center><a href='#' onclick='datos_editar($row_categorias[0])'>$row_categorias[0]</a></center>";
	$chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='activo($row_categorias[0])'></center>";
	$renglon = "
		{
		\"id_categoria\": \"$link_editar\",
		\"nombre_categoria\": \"$row_categorias[1]\",
		\"desc_categoria\": \"$row_categorias[2]\",
		\"activo_categoria\": \"$chk_activo\"
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