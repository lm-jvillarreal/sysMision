<?php
function detalle_articulo($almn_almacen, $artc_articulo){
  //Fecha
  date_default_timezone_set('America/Monterrey');
  $fecha = date('d/m/Y');
  $fecha_resta_actual = date('Y-m-d');

  //Se declaran todas las conexiones a sucursal
  $conexion_do = oci_connect('INFOFIN', 'INFOFIN', '200.1.1.165/DIAZORDAZ',"AL32UTF8");
  $conexion_arb = oci_connect('INFOFIN', 'INFOFIN', '200.1.3.55/ARBOLEDAS',"AL32UTF8");
  $conexion_vill = oci_connect('INFOFIN', 'INFOFIN', '200.1.2.230/VILLEGAS',"AL32UTF8");
  $conexion_all = oci_connect('INFOFIN', 'INFOFIN', '200.1.4.100/ALLENDE',"AL32UTF8");

  //se especifica cual conexion se requiere
  switch($almn_almacen){
    case 1:
      $conexion_central = $conexion_do;
    break;
    case 2:
      $conexion_central = $conexion_arb;
    break;
    case 3:
      $conexion_central = $conexion_vill;
    break;
    case 4:
      $conexion_central = $conexion_all;
    break;
  }

  $cadena_consulta = "SELECT ARTC_DESCRIPCION, artn_precioventa, artc_tipoimpuesto1, artc_tipoimpuesto2, artc_tipoimpuesto3 FROM PVS_ARTICULOS WHERE ARTC_ARTICULO = '$artc_articulo'";
  $parametros_consulta = oci_parse($conexion_central, $cadena_consulta);
  oci_execute($parametros_consulta);
  $row = oci_fetch_row($parametros_consulta);

  $artc_descripcion = $row[0];
	$artc_precioVenta = $row[1];
	$artc_impuesto1 = $row[2];
	$artc_impuesto2 = $row[3];
  $artc_impuesto3 = $row[4];
  
  //Se calculan y se adhieren el IVA e IEPS en caso que apliquen
	if ($artc_impuesto1 == '16') {
    $porcentaje_iva = "16";
		$precio_iva = $artc_precioVenta * 0.16;
	}else{
    $porcentaje_iva="0";
		$precio_iva = 0;
	}

	if ($artc_impuesto2 == 'IEPS') {
    $porcetaje_ieps = "8";
		$precio_ieps = $artc_precioVenta * 0.08;
	}elseif($artc_impuesto2 == 'IEPS6'){
    $precio_ieps = $artc_precioVenta * 0.06;
    $porcetaje_ieps = "6";
	}else{
    $precio_ieps = 0;
    $porcetaje_ieps="0";
	}

	//Se realiza la suma de los impuestos al precio total
	$precio_total = $artc_precioVenta + $precio_iva + $precio_ieps;
	//se redondea a dos decimales
  $precio_venta = number_format($precio_total,2,'.',' ');

  //Cadena de consulta para buscar ofertas
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
  AND artc.aroc_articulo = '$artc_articulo'
  AND artc.aroc_sucursal = '$almn_almacen'
  AND confi.coon_baja_sn = '0'
  AND artc.aron_baja_sn = '0'
  order by artc.aron_procdescuentooprecio ASC";
  
  //Se ejecuta la consulta de ofertas
  $parametros_ofertas = oci_parse($conexion_central,$cadena_ofertas);
  oci_execute($parametros_ofertas);
  $row_ofertas = oci_fetch_row($parametros_ofertas);
  $existe_oferta = oci_num_rows($parametros_ofertas);

  if ($existe_oferta==0) {
    //Se imprime codigo HTML con la información respectiva
    $precio_publico = $precio_venta;
    $tOferta = "NA";
    $vigencia_oferta = "";
    $dias ="";
  }else{ 
  //Se ejecuta si el artículo cuenta con alguna oferta
    $tipo_oferta = $row_ofertas[0];
    $cantidad_oferta = $row_ofertas[1];
    $vigencia_oferta = $row_ofertas[2];
    $fecha_resta_vigencia = $row_ofertas[3];

    if ($tipo_oferta=='0') {
      $precio_venta = $precio_total;
      $precio_descuento = $precio_venta - (($cantidad_oferta/100)*$precio_venta);
      $tOferta = "PORCENTAJE";
    }elseif ($tipo_oferta=='1') {
      $precio_descuento = $cantidad_oferta;
      $tOferta = "CANTIDAD";
    }
    $oferta = number_format($precio_descuento,2,'.',' ');
    //Se imprime código HTML con la información detallada de la oferta 
    $precio_publico = $oferta;

    $fecha1= new DateTime($fecha_resta_actual);
		$fecha2= new DateTime($fecha_resta_vigencia);
		$diff = $fecha1->diff($fecha2);
		if ($fecha_resta_actual==$fecha_resta_vigencia) {
			$dias = 1;
		}else{
			// El resultados sera 3 dias
			$dias =  $diff->days+1;
		}
  }
  
  $array=array(
    $artc_articulo, //Articulo
    $artc_descripcion, //Descripcion
    round($artc_precioVenta,2), //Subtotal
    $porcentaje_iva, //Porcentaje IVA
    round($precio_iva,2), //IVA
    $porcetaje_ieps, //Porcentaje IEPS
    round($precio_ieps,2), //IEPS
    $precio_venta, //Precio publico regular
    $tOferta, //Tipo de oferta
    $vigencia_oferta, //Fecha de vigencia
    $dias, //Dias restantes de la oferta
    $precio_publico //Precio publico final
  );
  $array = json_encode($array);
  return $array;
}
?>