<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
// $folio = $_POST['folio'];
//AGUA BONAFONT 12 1.5 LTS.
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$filtro_sucursal = ($solo_sucursal == '1') ? " AND sucursal = '$id_sede'" : "";
$cadena_detalle = "SELECT f.id, 
						  f.cve_articulo, 
						  f.descripcion_articulo,
						  f.estatus,
						  s.nombre,
						  f.sucursal,
						  date_format(fecha_captura , '%Y%m%d')
						  FROM faltantes_pasven as f INNER JOIN sucursales as s ON f.sucursal = s.id
						  WHERE f.estatus = '7'
						  and DATE(f.fecha_captura) BETWEEN DATE_SUB(NOW(),INTERVAL 7 DAY) AND DATE(NOW())";
//echo $cadena_detalle;
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$cuerpo ="";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
	$escape_desc = mysqli_real_escape_string($conexion, $row_detalle[2]);

	$cadena_existencia = "SELECT 
	spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 1, '$row_detalle[1]'), 
	spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 2, '$row_detalle[1]'), 
	spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 3, '$row_detalle[1]'), 
	spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 4, '$row_detalle[1]'),
	spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 5, '$row_detalle[1]'),
	spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 99, '$row_detalle[1]') 
FROM 
	dual";
	$st = oci_parse($conexion_central, $cadena_existencia);
	oci_execute($st);
	$row_existencia = oci_fetch_row($st);
	$link_detalle = "<center><a href='#' data-id = '$row_detalle[1]' data-suc = '$row_detalle[5]' data-inicio = '$row_detalle[6]' data-toggle = 'modal' data-target = '#modal-ue' class='btn btn-danger' target='blank'>$row_detalle[1]</a></center>";
	$estatus = ($row_detalle[3]!='7')? "<center><span class='label label-warning'>Pendiente</span></center>":"<center><span class='label label-success'>En Piso</span></center>";
	$liberar = "<center><a href='#' data-id = '$row_detalle[0]' data-toggle = 'modal' data-target = '#modal-coment' class='btn btn-success' target='blank'><i class='fa fa-check fa-lg' aria-hidden='true'></a></center>";
	$negar = "<center><a href='#' data-id = '$row_detalle[0]' data-toggle = 'modal' data-target = '#modal-negar' class='btn btn-danger' target='blank'><i class='fa fa-window-close fa-lg' aria-hidden='true'></a></center>";

	$renglon = "
	{
		\"no\": \"$row_detalle[0]\",
		\"codigo\": \"$link_detalle\",
		\"desc\": \"$escape_desc\",
		\"sucursal\": \"$row_detalle[4]\",
		\"do\": \"$row_existencia[0]\",
		\"arb\": \"$row_existencia[1]\",
		\"vill\": \"$row_existencia[2]\",
		\"all\": \"$row_existencia[3]\",
		\"pet\": \"$row_existencia[4]\",
		\"cedis\": \"$row_existencia[5]\",
		\"liberar\": \"$estatus\",
		\"existe_pv\": \"$liberar\",
		\"negar_pv\": \"$negar\"
	},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
//echo $cadena_cartas;
echo $tabla;
?>