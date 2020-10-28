<?php
$conexion_do = oci_connect('INFOFIN', 'INFOFIN', '200.1.1.165/DIAZORDAZ',"AL32UTF8");
$conexion_arb = oci_connect('INFOFIN', 'INFOFIN', '200.1.3.55/ARBOLEDAS',"AL32UTF8");
$conexion_vill = oci_connect('INFOFIN', 'INFOFIN', '200.1.2.230/VILLEGAS',"AL32UTF8");
$conexion_all = oci_connect('INFOFIN', 'INFOFIN', '200.1.4.100/ALLENDE',"AL32UTF8");
$conexion_lp = oci_connect('INFOFIN', 'INFOFIN', '200.1.5.100/PETACA',"AL32UTF8");

date_default_timezone_set('America/Monterrey');
$fecha = date('d/m/Y');
$fecha_resta_actual = date('Y-m-d');
$hora = date('H:i:s');

$p_codigo = $_POST['p_codigo'];
$sucursal = 'Misión Díaz Ordaz';

switch($sucursal){
  case 'Misión Díaz Ordaz':
    $conexion_central=$conexion_do;
  break;
  case 'Misión Arboledas':
    $conexion_central=$conexion_arb;
  break;
  case 'Misión Villegas':
    $conexion_central=$conexion_vill;
  break;
  case 'Misión Allende':
    $conexion_central=$conexion_all;
  break;
  case 'Misión Petaca':
    $conexion_central=$conexion_lp;
  break;
}

//$p_codigo='10';
$datos_articulo=array();
$cadena_consulta = "SELECT artc_descripcion, 
                           prfn_precio_con_imp, 
                           prfn_precio_con_imp_y_desc, 
                           prfn_dias_restantes_oferta, 
                           prfn_ahorro_en_pesos, 
                           TO_CHAR(prfd_fin_vigencia,'dd/MM/YYYY'), 
                           open_clave_agrupacion 
                    FROM pvs_precios_finales_vw where artc_articulo = '$p_codigo'";
$parametros_consulta = oci_parse($conexion_central, $cadena_consulta);
oci_execute($parametros_consulta);
$row = oci_fetch_row($parametros_consulta);

$cantidad_articulos = oci_num_rows($parametros_consulta);

if ($cantidad_articulos==0) {
  $existe='NO';
  $artc_descripcion='';
  $artc_precioVenta='';
  $artc_precioOferta='';
  $ofrt_diasRestantes='';
  $ofrt_ahorroPesos='';
  $ofrt_vigenciaFecha='';
  $ofrt_folio='';
}else{
  $existe='SI';
	$artc_descripcion = $row[0];
	$artc_precioVenta = $row[1];
  $artc_precioVenta = number_format($artc_precioVenta,2,'.',' ');
  $artc_precioOferta=$row[2];
  $ofrt_diasRestantes=$row[3];
  $ofrt_ahorroPesos=$row[4];
  $ofrt_vigenciaFecha=$row[5];
  $ofrt_folio=$row[6];
  if(is_null($ofrt_folio)){
    $ofrt_folio='';
  }else{
    $ofrt_folio=$ofrt_folio;
  }
}
array_push($datos_articulo,array(
  'existe'=>$existe,
  'artc_descripcion'=>$artc_descripcion,
  'artc_precioVenta'=>$artc_precioVenta,
  'artc_precioOferta'=>$artc_precioOferta,
  'ofrt_diasRestantes'=>$ofrt_diasRestantes,
  'ofrt_ahorroPesos'=>$ofrt_ahorroPesos,
  'ofrt_vigenciaFecha'=>$ofrt_vigenciaFecha,
  'ofrt_folio'=>$ofrt_folio
));
echo utf8_encode(json_encode($datos_articulo));
?>
