<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
include '../global_settings/conexion_sucursales.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha = date('d/m/Y');
$hora=date ("h:i:s");

$sucursal = $_POST['sucursal'];
$departamento = $_POST['departamento'];

$datos=array();

if($sucursal=='1'){
	$conexion_sucursal = $conexion_do;
}elseif($sucursal=='2'){
	$conexion_sucursal = $conexion_arb;
}elseif($sucursal=='3'){
	$conexion_sucursal = $conexion_vill;
}elseif($sucursal=='4'){
	$conexion_sucursal = $conexion_all;
}elseif($sucursal=='5'){
	$conexion_sucursal = $conexion_lp;
}

$cadena_codigos = "SELECT
                        (SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM = 1) AS Departamento,
                        FAM.FAMC_DESCRIPCION,
                        COM_ARTICULOS.ARTC_ARTICULO,
                        COM_ARTICULOS.ARTC_DESCRIPCION,
                        COM_ARTICULOS.ARTN_PRECIOVENTA,
                        COM_ARTICULOS.ARTC_IMPUESTO1,
                        COM_ARTICULOS.ARTC_IMPUESTO2,
                        COM_ARTICULOS.ARTC_IMPUESTO3,
                        COM_ARTICULOS.ARTN_PRECIO_ULTIMA_COMPRA
                    FROM
                        COM_ARTICULOS
                        INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA 
                    WHERE
                        COM_ARTICULOS.ARTN_ESTATUS = 1
                        AND FAM.FAMC_FAMILIAPADRE = '$departamento'";
$consulta_codigos = oci_parse($conexion_central, $cadena_codigos);
oci_execute($consulta_codigos);

$cuerpo ="";

while ($row_codigos = oci_fetch_row($consulta_codigos)) {
    $escape_depto = mysqli_real_escape_string($conexion, $row_codigos[0]);
    $escape_familia = mysqli_real_escape_string($conexion, $row_codigos[1]);
    $escape_descripcion = mysqli_real_escape_string($conexion, $row_codigos[3]);

    $artc_precioVenta = $row_codigos[4];
    $artc_impuesto1 = $row_codigos[5];
    $artc_impuesto2 = $row_codigos[6];

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
    
    $cadena_ofertas = "SELECT confi.coon_tipo, artc.aron_procdescuentooprecio,
												to_char(confi.cood_vigencia_fin,'DD/MM/YYYY'),
												to_char(confi.cood_vigencia_fin,'YYYY-MM-DD'),
												artc.aroc_sucursal,confi.cooc_descripcion,
												confi.coon_id_oferta
											FROM pvs_configuracion_oferta  confi
												INNER JOIN pvs_articulos_oferta artc
												ON confi.coon_id_oferta = artc.coon_id_oferta
												AND confi.cood_vigencia_ini <= TO_DATE('$fecha','dd/mm/yyyy')
												AND confi.cood_vigencia_fin >= TO_DATE('$fecha','dd/mm/yyyy')
												AND artc.aroc_articulo = '$row_codigos[2]'
												AND artc.aroc_sucursal = '$sucursal'
												AND confi.coon_baja_sn = '0'
												AND artc.aron_baja_sn = '0'
												ORDER BY artc.aron_procdescuentooprecio ASC";
	//echo $cadena_ofertas;
	//Se ejecuta la consulta de ofertas
	$parametros_ofertas = oci_parse($conexion_sucursal,$cadena_ofertas);
	oci_execute($parametros_ofertas);
	$row_ofertas = oci_fetch_row($parametros_ofertas);
	$existe_oferta = oci_num_rows($parametros_ofertas);

    if($existe_oferta==0){
			$folio_oferta="";
			$vigencia_oferta="";
			$oferta="";
    }else{
			$tipo_oferta = $row_ofertas[0];
			$cantidad_oferta = $row_ofertas[1];
			$vigencia_oferta = $row_ofertas[2];
			$fecha_resta_vigencia = $row_ofertas[3];
			$folio_oferta = $row_ofertas[6];

			if ($tipo_oferta=='0') {
				$precio_descuento = $precio_venta - (($cantidad_oferta/100)*$precio_venta);
			}elseif ($tipo_oferta=='1') {
				$precio_descuento = $cantidad_oferta;
			}
			$oferta = number_format($precio_descuento,2,'.',' ');
    }
		
	array_push($datos,array(
		"depto"=>$escape_depto,
		"familia"=>$escape_familia,
		"codigo"=>$row_codigos[2],
		"descripcion"=>$escape_descripcion,
		"precio"=>$precio_venta,
		"costo"=>$row_codigos[8],
		"folio_oferta"=>$folio_oferta,
		"vigencia_oferta"=>$vigencia_oferta,
		"oferta"=>$oferta
	));
}
echo utf8_encode(json_encode($datos));
?>