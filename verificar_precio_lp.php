<?php
$conexion_central = oci_connect('INFOFIN', 'INFOFIN', '200.1.5.100/PETACA',"AL32UTF8");
//se crea la variable local
date_default_timezone_set('America/Monterrey');
$fecha = date('d/m/Y');
$fecha_resta_actual = date('Y-m-d');
$hora = date('H:i:s');
$p_codigo = $_POST['codigo_producto'];
//$p_codigo = '250';
//se declara e inicializa la variable de la consulta
$cadena_consulta = "SELECT artc_descripcion, prfn_precio_con_imp, prfn_precio_con_imp_y_desc, prfn_dias_restantes_oferta, prfn_ahorro_en_pesos, TO_CHAR(prfd_fin_vigencia,'dd/MM/YYYY'), open_clave_agrupacion FROM pvs_precios_finales_vw where artc_articulo = '$p_codigo'";
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
	$artc_descripcion = $row[0];
	//Se realiza la suma de los impuestos al precio total
	$precio_total = $row[1];
	//se redondea a dos decimales
	$precio_venta = number_format($precio_total,2,'.',' ');

	///Se ejecuta si la oferta no existe
	if(is_null($row[6])) {
		//Se imprime codigo HTML con la información respectiva
		echo '
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="descripcion text-center">'.$artc_descripcion.'</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h4 class="precio text-center">$'.$precio_venta.'</h4>
				</div>
			</div>
		</div>
		';
	}else{ 
	//Se ejecuta si el artículo cuenta con alguna oferta
	$oferta = $row[2];
	$oferta = number_format($oferta,2,'.',' ');
	$ahorro = $row[4];
	$folio_oferta = $row[6];
	$vigencia_oferta = $row[5];
	$dias =$row[3];
		
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
