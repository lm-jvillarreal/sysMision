<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';

if($id_sede=='1'){
	$conexion_central = $conexion_do;
}elseif($id_sede=='2'){
	$conexion_central = $conexion_arb;
}elseif($id_sede=='3'){
	$conexion_central = $conexion_vill;
}elseif($id_sede=='4'){
	$conexion_central = $conexion_all;
}elseif($id_sede=='5'){
	$conexion_central = $conexion_lp;
}
date_default_timezone_set('America/Monterrey');
$fecha = date('d/m/Y');
$fecha_resta_actual = date('Y-m-d');
$hora = date('H:i:s');
$codigo = $_POST['codigo_producto'];

//se declara e inicializa la variable de la consulta
$cadena_consulta = "SELECT artc_descripcion, prfn_precio_con_imp, prfn_precio_con_imp_y_desc, prfn_dias_restantes_oferta, prfn_ahorro_en_pesos, TO_CHAR(prfd_fin_vigencia,'dd/MM/YYYY'), open_clave_agrupacion FROM pvs_precios_finales_vw where artc_articulo = '$codigo'";
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
						<h4 class="descripcion">EL ARTÍCULO NO EXISTE</h4>
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
				<div class="col-md-12">
					<h4 class="descripcion text-center">'.$artc_descripcion.'</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<label class="texto-oferta">Oferta</label>
				</div>
				<div class="col-md-12">
					<h4 class="oferta text-center">$'.$oferta.'</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 text-left">
					<h4>Folio:</h4>
				</div>
				<div class="col-xs-6 text-right">
					<h4>'.$folio_oferta.'</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 text-left">
					<h4>Vigencia:</h4>
				</div>
				<div class="col-xs-6 text-right">
					<h4>'.$vigencia_oferta.'</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 text-left">
					<h4>Días de vigencia:</h4>
				</div>
				<div class="col-xs-6 text-right">
					<h4>'.$dias.'</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 text-left">
					<h4>Descuento:</h4>
				</div>
				<div class="col-xs-6 text-right">
					<h4>$'.number_format($ahorro,2,'.',' ').'</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 text-left">
					<h4>Precio reg:</h4>
				</div>
				<div class="col-xs-6 text-right">
					<h4>'.$precio_venta.'</h4>
				</div>
			</div>
		</div>
		';
	}
}
 ?>