<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$no_catalogo = $_POST['num_catalogo'];

$filtro_ss = (!empty($solo_sucursal) == '1') ? " AND sucursal = '$id_sede'" : " AND sucursal = '$id_sede'";

$cadena_productos = "SELECT id, cve_producto, desc_producto FROM cp_catalogos WHERE no_catalogo = '$no_catalogo'".$filtro_ss;

$consulta_productos = mysqli_query($conexion, $cadena_productos);

$cuerpo ="";

while ($row_productos = mysqli_fetch_array($consulta_productos)) {

	$link_remover = "<center><a href='#' onclick='eliminar_articulo($row_productos[0])' class='btn btn-danger'>Remover</a></center>";
	$renglon = "
		{
		\"id\": \"$row_productos[0]\",
		\"cve_producto\": \"$row_productos[1]\",
		\"desc_producto\": \"$row_productos[2]\",
		\"remover\": \"$link_remover\"
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