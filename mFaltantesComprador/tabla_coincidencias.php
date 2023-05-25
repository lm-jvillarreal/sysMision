<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
// $folio = $_POST['folio'];

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$filtro_rp = ($registros_propios == '1') ? " AND f.id_comprador = '$id_usuario'" : "";

$cadena_detalle = "SELECT f.cve_articulo, 
                    f.cve_articulo,
                    f.descripcion_articulo,
                    f.depto, 
                    f.familia,
                    count(cve_articulo) as conteo,
                    (SELECT nombre FROM sucursales WHERE id=f.sucursal)
                    FROM faltantes_pasven as f
                    WHERE (f.estatus = '1' or f.estatus='3' or f.estatus='4')
                    GROUP BY f.cve_articulo, f.sucursal
                    order by count(*)";

$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$cuerpo ="";
$i = 1;
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
    
	$escape_desc = mysqli_real_escape_string($conexion, $row_detalle[2]);
	$escape_depto = mysqli_real_escape_string($conexion, $row_detalle[3]);
	$escape_fam = mysqli_real_escape_string($conexion, $row_detalle[4]);

	$cadena_existencia = "SELECT 
	spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 1, '$row_detalle[1]'), 
	spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 2, '$row_detalle[1]'), 
	spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 3, '$row_detalle[1]'), 
	spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 4, '$row_detalle[1]'),
	spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 5, '$row_detalle[1]'),
	spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 99, '$row_detalle[1]'),
	(SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO='$row_detalle[1]') AS DESCRIPCION   
FROM 
	dual";
	$st = oci_parse($conexion_central, $cadena_existencia);
	oci_execute($st);
	$row_existencia = oci_fetch_row($st);
	$conteo="<center><a href='#' data-articulo = '$row_detalle[1]' data-toggle = 'modal' data-target = '#modal-conteo' target='blank'>$row_detalle[5]</a></center>";
	$do = "<center><a href='#' data-id = '$row_detalle[1]' data-suc = '1'  data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[0]</a></center>";
	$arb = "<center><a href='#' data-id = '$row_detalle[1]' data-suc = '2'  data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[1]</a></center>";
	$vill = "<center><a href='#' data-id = '$row_detalle[1]' data-suc = '3'  data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[2]</a></center>";
	$all = "<center><a href='#' data-id = '$row_detalle[1]' data-suc = '4'  data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[3]</a></center>";
	$pet = "<center><a href='#' data-id = '$row_detalle[1]' data-suc = '5'  data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[4]</a></center>";
	$cedis = "<center><a href='#' data-id = '$row_detalle[1]' data-suc = '99'  data-toggle = 'modal' data-target = '#modal-ue' target='blank'>$row_existencia[5]</a></center>";
	$artc_descripcion = mysqli_real_escape_string($conexion,$row_existencia[6]);
	$renglon = "
	{
		\"no\": \"$i\",
		\"depto\": \"$escape_depto\",
		\"fam\": \"$escape_fam\",
		\"codigo\": \"$row_detalle[1]\",
		\"descripcion\": \"$artc_descripcion\",
		\"sucursal\": \"$row_detalle[6]\",
		\"conteo\": \"$conteo\",
		\"do\": \"$do\",
		\"arb\": \"$arb\",
		\"vill\": \"$vill\",
		\"all\": \"$all\",
		\"pet\": \"$pet\",
		\"cedis\": \"$cedis\"
	},";
    $cuerpo = $cuerpo.$renglon;
    $i=$i+1;
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