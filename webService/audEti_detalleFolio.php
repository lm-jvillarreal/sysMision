<?php
include '../global_settings/conexion.php';
include '../global_settings/conexion_sucursales.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$id_usuario=$_POST['id_persona'];
$folio=$_POST['folio'];
$codigo=$_POST['codigo'];
$cantidad=$_POST['cantidad'];

$cadenaSucursal="SELECT (SELECT id_sede FROM personas WHERE id=usuarios.id_persona) FROM usuarios where id='$id_usuario'";
$consultaSucursal=mysqli_query($conexion,$cadenaSucursal);
$rowSucursal=mysqli_fetch_array($consultaSucursal);
$id_sede=$rowSucursal[0];

if($id_sede=='1'){
	$conexion_central = $conexion_do;
}elseif($id_sede=='2'){
	$conexion_central = $conexion_arb;
}elseif($id_sede=='3'){
	$conexion_central = $conexion_vill;
}elseif($id_sede=='4'){
	$conexion_central = $conexion_all;
}elseif($id_sede=='5'){
  $conexion_central=$conexion_lp;
}

$datos_articulo=array();
$cadena_consulta = "SELECT artc_descripcion, 
                           prfn_precio_con_imp, 
                           prfn_precio_con_imp_y_desc, 
                           prfn_dias_restantes_oferta, 
                           prfn_ahorro_en_pesos, 
                           TO_CHAR(prfd_fin_vigencia,'dd/MM/YYYY'), 
                           open_clave_agrupacion 
                    FROM pvs_precios_finales_vw where artc_articulo = '$codigo'";
$parametros_consulta = oci_parse($conexion_central, $cadena_consulta);
oci_execute($parametros_consulta);
$row = oci_fetch_row($parametros_consulta);
$cantidad_articulos = oci_num_rows($parametros_consulta);

if($cantidad_articulos==0){
  $existe='no';
  $artc_descripcion='';
  $artc_precioVenta='';
  $artc_precioOferta='';
  $ofrt_folio='';
}else{
  $existe='SI';
	$artc_descripcion = $row[0];
	$artc_precioVenta = $row[1];
  $artc_precioVenta = number_format($artc_precioVenta,2,'.',' ');
  $artc_precioOferta=$row[2];
  $ofrt_folio=$row[6];
  if(is_null($ofrt_folio)){
    $ofrt_folio='';
  }else{
    $ofrt_folio=$ofrt_folio;
  }
  array_push($datos_articulo,array(
    'existe'=>$existe,
    'artc_descripcion'=>$artc_descripcion,
    'artc_precioVenta'=>$artc_precioVenta,
    'artc_precioOferta'=>$artc_precioOferta,
    'ofrt_folio'=>$ofrt_folio
  ));
  echo utf8_encode(json_encode($datos_articulo));
}
?>