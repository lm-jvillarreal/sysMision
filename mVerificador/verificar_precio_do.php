<?php
$conexion_central = oci_connect('INFOFIN', 'INFOFIN', '200.1.1.165/DIAZORDAZ');
//se crea la variable local
date_default_timezone_set('America/Monterrey');
$fecha = date('d/m/Y');
$fecha_resta_actual = date('Y-m-d');
$hora = date('H:i:s');
$p_codigo = $_POST['codigo_producto'];
//$p_codigo = '250';
//se declara e inicializa la variable de la consulta
$cadena_consulta = "SELECT ARTC_DESCRIPCION, artn_precioventa, artc_tipoimpuesto1, artc_tipoimpuesto2, artc_tipoimpuesto3 FROM PVS_ARTICULOS WHERE ARTC_ARTICULO = '$p_codigo'";

$parametros_consulta = oci_parse($conexion_central, $cadena_consulta);
oci_execute($parametros_consulta);

$row = oci_fetch_row($parametros_consulta);

$cantidad_articulos = oci_num_rows($parametros_consulta);

if ($cantidad_articulos==0) {
	echo '
		<div class="container">
			<div class="contenerdor">
				<div class="row text-center">
					<div class="col-md-12">
						<h5 class="descripcion">EL ARTÍCULO NO EXISTE</h5>
					</div>
				</div>
			</div>
		</div>
	';
}else{
	//Variables locales
	$artc_descripcion = $row[0];
	$artc_precioVenta = $row[1];
	$artc_impuesto1 = $row[2];
	$artc_impuesto2 = $row[3];
	$artc_impuesto3 = $row[4];

	//Se calculan y se adhieren el IVA e IEPS en caso que apliquen
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


	//Cadena de consulta para buscar ofertas
	$cadena_ofertas = "SELECT confi.coon_tipo, artc.aron_procdescuentooprecio,
        to_char(confi.cood_vigencia_fin,'DD/MM/YYYY'),
        to_char(confi.cood_vigencia_fin,'YYYY-MM-DD'),
        artc.aroc_sucursal,confi.cooc_descripcion
        FROM pvs_configuracion_oferta  confi
        INNER JOIN pvs_articulos_oferta artc
        ON confi.coon_id_oferta = artc.coon_id_oferta
        AND confi.cood_vigencia_ini <= TO_DATE('$fecha','dd/mm/yyyy')
        AND confi.cood_vigencia_fin >= TO_DATE('$fecha','dd/mm/yyyy')
        AND artc.aroc_articulo = '$p_codigo'
        AND artc.aroc_sucursal = '1'";
	//echo $cadena_ofertas;
	//Se ejecuta la consulta de ofertas
	$parametros_ofertas = oci_parse($conexion_central,$cadena_ofertas);
	oci_execute($parametros_ofertas);
	$row_ofertas = oci_fetch_row($parametros_ofertas);
	$existe_oferta = oci_num_rows($parametros_ofertas);
	

	///Se ejecuta si la oferta no existe
	if ($existe_oferta==0) {
		//Se imprime codigo HTML con la información respectiva
		echo '
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<center><label style="font-size: 30px">'.$artc_descripcion.'</label></center>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h5 class="precio text-center">$'.$precio_venta.'</h5>
				</div>
			</div>
		</div>
		';


	}else{ 
	//Se ejecuta si el artículo cuenta con alguna oferta
		$tipo_oferta = $row_ofertas[0];
		$cantidad_oferta = $row_ofertas[1];
		$vigencia_oferta = $row_ofertas[2];
		$fecha_resta_vigencia = $row_ofertas[3];

		if ($tipo_oferta=='0') {
			$precio_descuento = $precio_venta - (($cantidad_oferta/100)*$precio_venta);
		}elseif ($tipo_oferta=='1') {
			$precio_descuento = $cantidad_oferta;
		}
		$oferta = number_format($precio_descuento,2,'.',' ');

		$fecha1= new DateTime($fecha_resta_actual);
		$fecha2= new DateTime($fecha_resta_vigencia);
		$diff = $fecha1->diff($fecha2);
		if ($fecha_resta_actual==$fecha_resta_vigencia) {
			$dias = 1;
		}else{
			// El resultados sera 3 dias
			$dias =  $diff->days+1;
		}
		
		//Se imprime código HTML con la información detallada de la oferta 
		echo '
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<table border="0" align="center" width="100%">
						<tr>
							<td colspan="3">
								<label style="font-size: 20px">'.$artc_descripcion.'<label>
							</td>
						</tr>
						<tr>
							<td width="50%">
								<label class="texto-oferta">Oferta</label>
							</td>
							<td width="25%" rowspan="2" align="left">
								<label>Vigencia:</label>
								<br>
								<label>Días de Vigencia:</label>
								<br>
								<label>Descuento:</label>
								<br>
								<label>Precio reg:</label>
							</td>
							<td width="25%" rowspan="2" align="right">
								<label>'.$vigencia_oferta.'</label>
								<br>
								<label>'.$dias.'</label>
								<br>
								<label>$'.number_format($precio_venta - $oferta,2,'.',' ').'</label>
								<br>
								<label>$'.$precio_venta.'</label>
							</td>
						</tr>
						<tr>
							<td>
								<strong><h5 class="oferta text-center">$'.$oferta.'</h5></strong>
							</td>
						</tr>
					</table>
				</div>
			</row>
		</div>
		';
	}
}
 ?>