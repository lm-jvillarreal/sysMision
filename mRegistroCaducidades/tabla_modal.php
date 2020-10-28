<?php 
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';

date_default_timezone_set("America/Monterrey");
$fecha = date("d/m/Y");

$codigo = $_POST['codigo'];
$codigo_producto = $_POST['codigo'];
$fecha_captura = $_POST['fecha'];
$sucursal = $_POST['sucursal'];

if($sucursal == '1'){
	$conexion_centr = $conexion_do;
}elseif($sucursal == '2'){
	$conexion_centr = $conexion_arb;
}elseif($sucursal=='3'){
	$conexion_centr = $conexion_vill;
}elseif($sucursal=='4'){
	$conexion_centr = $conexion_all;
}

$cadena_movimientos = "SELECT * FROM (SELECT
                        detalle.MODN_FOLIO,
                        TO_CHAR(movs.MOVD_FECHAAFECTACION, 'DD/MM/YYYY'),
                        detalle.modc_tipomov,
                        detalle.RMON_CANTSURTIDA,
                        detalle.RMOC_UNIMEDIDA,
                        movs.MOVC_CVEPROVEEDOR
                        FROM
                        INV_RENGLONES_MOVIMIENTOS detalle
                        INNER JOIN INV_MOVIMIENTOS movs ON movs.ALMN_ALMACEN = detalle.ALMN_ALMACEN 
                        AND detalle.MODN_FOLIO = movs.MODN_FOLIO 
                        AND movs.MODC_TIPOMOV = detalle.MODC_TIPOMOV 
                        WHERE
                        ARTC_ARTICULO = '$codigo' 
                        AND movs.MOVD_FECHAAFECTACION IS NOT NULL
                        AND ( detalle.MODC_TIPOMOV = 'SXMBOD' OR 
                              detalle.MODC_TIPOMOV = 'SXMCAR' OR 
                              detalle.MODC_TIPOMOV = 'SXMFCI' OR 
                              detalle.MODC_TIPOMOV = 'SXMFTA' OR 
                              detalle.MODC_TIPOMOV = 'SXMEDO' OR 
                              detalle.MODC_TIPOMOV = 'SXMPAN' OR 
                              detalle.MODC_TIPOMOV = 'SXMTOR' OR 
                              detalle.MODC_TIPOMOV = 'SXMVAR' OR 
                              detalle.MODC_TIPOMOV = 'SXROB'
                            )
                        AND movs.movd_fechaafectacion >= TO_DATE('$fecha_captura','dd/mm/yyyy')
                        AND movs.movd_fechaafectacion <= TO_DATE('$fecha','dd/mm/yyyy')
                        AND movs.ALMN_ALMACEN = '$id_sede'
                        ORDER BY
                        movs.MOVD_FECHAAFECTACION DESC)";
$consulta_movimientos = oci_parse($conexion_central, $cadena_movimientos);
oci_execute($consulta_movimientos);

//consulta de precios//////////////
$cadena_consulta = "SELECT ARTC_DESCRIPCION, artn_precioventa, artc_tipoimpuesto1, artc_tipoimpuesto2, artc_tipoimpuesto3 FROM PVS_ARTICULOS WHERE ARTC_ARTICULO = '$codigo_producto'";
$st = oci_parse($conexion_centr, $cadena_consulta);
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
        AND artc.aroc_sucursal = '$sucursal'
        AND confi.coon_baja_sn = '0'";
	//echo $cadena_ofertas;
	//Se ejecuta la consulta de ofertas
	$parametros_ofertas = oci_parse($conexion_centr,$cadena_ofertas);
	oci_execute($parametros_ofertas);
	$row_ofertas = oci_fetch_row($parametros_ofertas);
	$existe_oferta = oci_num_rows($parametros_ofertas);

	$tipo_oferta = $row_ofertas[0];
	$cantidad_oferta = $row_ofertas[1];

	if ($tipo_oferta=='0') {
		$precio_descuento = $precio_venta - (($cantidad_oferta/100)*$precio_venta);
	}elseif ($tipo_oferta=='1') {
		$precio_descuento = $cantidad_oferta;
	}else{
		$precio_descuento = "";
	}
$precio = round($row_producto[1],2);
////////////////////
//echo $cadena_detalle;
$body = "";
$encabezado = "
  <div class=\"row\">
    <div class=\"col-md-6\">
      <div class=\"form-group\">
        <label for=\"ppublico\">*Precio Público</label>
        <input type=\"text\" name=\"ppublico\" id=\"ppublico\" class=\"form-control\" value='$precio_venta' readonly>
      </div>
    </div>
    <div class=\"col-md-6\">
      <div class=\"form-group\">
        <label for=\"poferta\">*Precio Oferta</label>
        <input type=\"text\" name=\"poferta\" id=\"poferta\" class=\"form-control\" value='$precio_descuento' readonly>
      </div>
    </div>
  </div>
	<div class='table-responsive'>
        <table id='lista_merma' class='table table-striped table-bordered' cellspacing='0' width='100%'>
	        <thead>
            <tr>
                <th width='5%'>Folio</th>
                <th width='10%'>Fecha</th>
                <th width='10%'>Mov</th>
                <th width='10%'>Cantidad</th>
            </tr>
	        </thead>
	        <tbody>";
	        	while($row = oci_fetch_row($consulta_movimientos))
				{
					$fila = "	
            <tr>
              <td>".$row[0]."</td>
              <td>".$row[1]."</td>
              <td>".$row[2]."</td>
              <td>".$row[3]."</td>
            </tr>";
					$body = $body.$fila;
				}
$footer = "
	        </tbody>  
		</table>
	</div>";

$tabla = $encabezado.$body.$footer;

echo $tabla;