<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
// $folio = $_POST['folio'];

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$filtro_rp = ($registros_propios == '1') ? " AND f.id_comprador = '$id_usuario'" : "";

$cadena_detalle = "SELECT f.id, 
						  f.cve_articulo, 
						  f.descripcion_articulo, 
						  s.nombre, 
						  f.id_comprador, 
						  f.depto, 
						  f.familia, date_format(fecha_captura,'%Y-%m-%d')
				   FROM faltantes_pasven as f INNER JOIN sucursales as s ON f.sucursal = s.id
					WHERE f.estatus = '3'
					and DATE(f.fecha_captura) BETWEEN DATE_SUB(NOW(),INTERVAL 7 DAY) AND DATE(NOW())";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$cuerpo ="";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {

	$escape_desc = mysqli_real_escape_string($conexion, $row_detalle[2]);
	$escape_depto = mysqli_real_escape_string($conexion, $row_detalle[5]);
	$escape_fam = mysqli_real_escape_string($conexion, $row_detalle[6]);

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

	$check = "<div class='checkbox'><label><input type='checkbox' name='liberar[]' value='$row_detalle[0]'></label></div>";
	$liberar = "<center><a href='#' data-id = '$row_detalle[0]' data-toggle = 'modal' data-target = '#modal-coment' class='btn btn-warning' target='blank'><i class='fa fa-search fa-lg' aria-hidden='true'></a></center>";
	$ajuste = "<center><a href='#' onclick='ajuinv($row_detalle[0])' class='btn btn-danger'><i class='fa fa-server fa-lg' aria-hidden='true'></a></center>";
	
	$do = "<center><a href='#' data-id = '$row_detalle[1]' data-suc = '1' data-ini = '$row_detalle[7]' data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[0]</a></center>";
	$arb = "<center><a href='#' data-id = '$row_detalle[1]' data-suc = '2' data-ini = '$row_detalle[7]' data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[1]</a></center>";
	$vill = "<center><a href='#' data-id = '$row_detalle[1]' data-suc = '3' data-ini = '$row_detalle[7]' data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[2]</a></center>";
	$all = "<center><a href='#' data-id = '$row_detalle[1]' data-suc = '4' data-ini = '$row_detalle[7]' data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[3]</a></center>";
	$pet = "<center><a href='#' data-id = '$row_detalle[1]' data-suc = '4' data-ini = '$row_detalle[7]' data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[4]</a></center>";
	$cedis = "<center><a href='#' data-id = '$row_detalle[1]' data-suc = '4' data-ini = '$row_detalle[7]' data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[5]</a></center>";
	$sucursal = "<center><a href='#' data-id = '$row_detalle[0]' data-id_compra = '$row_detalle[4]' data-toggle = 'modal' data-target = '#modal-comp'>$row_detalle[3]</center>";
	$renglon = "
	{
		\"no\": \"$check\",
		\"depto\": \"$escape_depto\",
		\"fam\": \"$escape_fam\",
		\"codigo\": \"$row_detalle[1]\",
		\"descripcion\": \"$escape_desc\",
		\"sucursal\": \"$row_detalle[3]\",
		\"do\": \"$do\",
		\"arb\": \"$arb\",
		\"vill\": \"$vill\",
		\"all\": \"$all\",
		\"pet\": \"$pet\",
		\"cedis\": \"$cedis\",
		\"liberar\": \"$liberar\",
		\"ajuste\": \"$ajuste\"
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