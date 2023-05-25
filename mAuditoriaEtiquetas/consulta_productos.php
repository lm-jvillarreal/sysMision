<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';

$fecha = date('d/m/Y');
$precio = 0;

if($id_sede == '1'){
	$conexion_central = $conexion_do;
}elseif($id_sede=='2'){
	$conexion_central = $conexion_arb;
}elseif($id_sede=='3'){
	$conexion_central = $conexion_vill;
}elseif($id_sede=='4'){
	$conexion_central = $conexion_all;
}elseif($id_sede=='5'){
	$conexion_central = $conexion_lp;
}elseif($id_sede=='6'){
	$conexion_central = $conexion_mm;
}

$codigo_producto = $_POST['codigo'];

$cadena_consulta = "SELECT ARTC_DESCRIPCION, artn_precioventa, artc_tipoimpuesto1, artc_tipoimpuesto2, artc_tipoimpuesto3 FROM PVS_ARTICULOS WHERE ARTC_ARTICULO = '$codigo_producto'";
$st = oci_parse($conexion_central, $cadena_consulta);
oci_execute($st);
$row_producto = oci_fetch_row($st);

$artc_descripcion = $row_producto[0];
$artc_precioVenta = $row_producto[1];
$artc_impuesto1 = $row_producto[2];
$artc_impuesto2 = $row_producto[3];
$artc_impuesto3 = $row_producto[4];

if ($artc_impuesto1 == '16') {
	$precio_iva = $artc_precioVenta * 0.16;
}else{
	$precio_iva = 0;
}

if ($artc_impuesto2 == 'IEPS') {
	$precio_ieps = $artc_precioVenta * 0.08;
}elseif($artc_impuesto2 == 'IEPS6'){
	$precio_ieps = $artc_precioVenta * 0.06;
}else{
	$precio_ieps = 0;
}

//Se realiza la suma de los impuestos al precio total
$precio_total = $artc_precioVenta + $precio_iva + $precio_ieps;
//se redondea a dos decimales
$precio_venta = number_format($precio_total,2,'.',' ');

$cadena_ofertas = "SELECT confi.coon_tipo, artc.aron_procdescuentooprecio
        FROM pvs_configuracion_oferta  confi
        INNER JOIN pvs_articulos_oferta artc
        ON confi.coon_id_oferta = artc.coon_id_oferta
        AND confi.cood_vigencia_ini <= TO_DATE('$fecha','dd/mm/yyyy')
        AND confi.cood_vigencia_fin >= TO_DATE('$fecha','dd/mm/yyyy')
        AND artc.aroc_articulo = '$codigo_producto'
        AND artc.aroc_sucursal = '$id_sede'
        AND confi.coon_baja_sn = '0'
		AND artc.aron_baja_sn = '0'
		order by artc.aron_procdescuentooprecio asc";
	//echo $cadena_ofertas;
	//Se ejecuta la consulta de ofertas
	$parametros_ofertas = oci_parse($conexion_central,$cadena_ofertas);
	oci_execute($parametros_ofertas);
	$row_ofertas = oci_fetch_row($parametros_ofertas);
	$existe_oferta = oci_num_rows($parametros_ofertas);

	$tipo_oferta = $row_ofertas[0];
	$cantidad_oferta = $row_ofertas[1];

	if ($tipo_oferta=='0') {
		$precio_venta = $precio_total;
		$precio_descuento = $precio_venta - (($cantidad_oferta/100)*$precio_venta);
		$precio_venta = round($precio_venta,2);
		$precio_descuento = round($precio_descuento,2);
	}elseif ($tipo_oferta=='1') {
		$precio_descuento = $cantidad_oferta;
	}else{
		$precio_descuento = "";
	}
$precio = round($row_producto[1],2);
$array = array(
	$row_producto[0],
	$precio_venta,
	$precio_descuento
	);

$array_datos = json_encode($array);
echo "$array_datos"; 
?>