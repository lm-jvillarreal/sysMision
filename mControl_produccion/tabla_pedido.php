<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$no_catalogo = $_POST['num_catalogo'];
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_fin = $_POST['fecha_final'];

$fecha_inicial = explode("-",$fecha_inicio);
$prefijo_ini = implode("",$fecha_inicial);

$fecha_final = explode("-",$fecha_fin);
$prefijo_fin = implode("",$fecha_final);

//echo $prefijo_ini;
//echo $prefijo_fin;

$filtro_ss = (!empty($solo_sucursal) == '1') ? " AND sucursal = '$id_sede'" : " AND sucursal = '$id_sede'";

$cadena_productos = "SELECT id, cve_producto, desc_producto FROM cp_catalogos WHERE no_catalogo = '$no_catalogo'".$filtro_ss;

$consulta_productos = mysqli_query($conexion, $cadena_productos);

$cuerpo ="";

while ($row_productos = mysqli_fetch_array($consulta_productos)) {


	$cadena_maxId = "SELECT MAX(id) FROM cp_historial_movimientos WHERE cve_producto = '$row_productos[1]' ORDER BY id DESC LIMIT 1";
	$consulta_maxId = mysqli_query($conexion, $cadena_maxId);
	$row_maxId = mysqli_fetch_array($consulta_maxId);
	$maxId = $row_maxId[0];

	$cadena_mermas = "SELECT inv_arranque, inv_cierre,  baja_merma FROM cp_historial_movimientos WHERE id = '$maxId'";
	$consulta_mermas = mysqli_query($conexion, $cadena_mermas);
	$row_merma = mysqli_fetch_array($consulta_mermas);
	$inv_arranque = $row_merma[0];
	$inv_cierre = $row_merma[1];
	$mermas = $row_merma[2];

	$cadena_ventas = "SELECT SUM(ARTN_CANTIDAD) FROM PV_ARTICULOSTICKET 
						WHERE (ticn_aaaammddventa >= '$prefijo_ini' AND ticn_aaaammddventa <= '$prefijo_fin')
						AND artc_articulo = '$row_productos[1]' 
						AND ticc_sucursal = '$id_sede'";

	$consulta_ventas = oci_parse($conexion_central, $cadena_ventas);
	oci_execute($consulta_ventas);
	$row_ventas=oci_fetch_row($consulta_ventas);
	$ventas = $row_ventas[0];

	$inv_final = $inv_arranque - $mermas - $ventas;

	$inv_inicial = "<input type='number' name='inv_inicial[]'  readonly='true' value='$inv_arranque' style='width:100%' class='form-control'>";
	$cant_merma = "<input type='number' name='cant_merma[]'  value='$mermas' readonly='true' style='width:100%' class='form-control'>";
	$cant_ventas = "<input type='number' name='cant_ventas[]'  readonly='true' value='$ventas' style='width:100%' class='form-control'>";
	$cant_restante = "<input type='number' name='cant_restante[]'  value='$inv_final' readonly='true' style='width:100%' class='form-control'>";
	$cant_pedido = "<input type='number' name='pedido[]' style='width:100%' class='form-control'>";
	$observaciones = "<input type='text' name='observaciones[]' style='width:100%' class='form-control'>";
	$cod_prod = "<input type='hidden' name='cod_prod[]' id='codigoss' value='$row_productos[1]'>".$row_productos[1];
	$desc_prod = "<input type='hidden' name='desc_prod[]' id='descripcionn' value='$row_productos[2]'>".$row_productos[2];
	$pedido = "";
	$renglon = "
		{
		\"id\": \"$row_productos[0]\",
		\"cve_producto\": \"$cod_prod\",
		\"desc_producto\": \"$desc_prod\",
		\"inv_inicial\": \"$inv_inicial\",
		\"cant_merma\": \"$cant_merma\",
		\"cant_ventas\": \"$cant_ventas\",
		\"cant_restante\": \"$cant_restante\",
		\"cant_pedido\": \"$cant_pedido\",
		\"observaciones\": \"$observaciones\"
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