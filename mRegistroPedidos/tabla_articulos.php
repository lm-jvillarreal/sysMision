<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';
include '../global_settings/conexion_oracle.php';

if($id_sede=='1'){
	$conexion_sucursal = $conexion_do;
}elseif($id_sede=='2'){
	$conexion_sucursal = $conexion_arb;
}elseif($id_sede=='3'){
	$conexion_sucursal = $conexion_vill;
}elseif($id_sede=='4'){
	$conexion_sucursal = $conexion_all;
}
date_default_timezone_set('America/Monterrey');
$fecha = date('d/m/Y');
$fecha_resta_actual = date('Y-m-d');
$hora = date('H:i:s');
$descripcion = $_POST['descripcion'];

$cadena_consulta = "SELECT a_v.artc_descripcion, 
                          a_v.prfn_precio_con_imp, 
                          a_v.prfn_precio_con_imp_y_desc, 
                          a_v.prfn_dias_restantes_oferta, 
                          a_v.prfn_ahorro_en_pesos, 
                          TO_CHAR(a_v.prfd_fin_vigencia,'dd/MM/YYYY'), 
                          a_v.open_clave_agrupacion, 
                          a_v.artc_articulo,
                          a.ARTC_UNIMEDIDA_VENTA
                          FROM pvs_precios_finales_vw a_v
                          INNER JOIN PVS_ARTICULOS a ON a_v.ARTC_ARTICULO = a.artc_articulo 
                          WHERE a_v.artc_descripcion LIKE '%$descripcion%'
                          AND a.ARTN_BAJA = '0'";
$parametros_consulta = oci_parse($conexion_sucursal, $cadena_consulta);
oci_execute($parametros_consulta);

$i=0;
$cuerpo ="";
while ($row = oci_fetch_row($parametros_consulta)) {
  $i=$i+1;
  if(is_null($row[6])){
    $precio_venta = $row[1];
  }else{
    $precio_venta = $row[2];
  }

  $cadena_existencia ="SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, $id_sede, '$row[7]') FROM dual";
  $parametros_existencia = oci_parse($conexion_central,$cadena_existencia);
  oci_execute($parametros_existencia);
  $rowExistencia = oci_fetch_row($parametros_existencia);

  $link = "<center><a href='#' class='btn btn-success' onclick='agregar($row[7],$i)'><i class='fa fa-check fa-lg' aria-hidden='true'></i></a></center>";
  //$ver = "<center><a href='#' data-folio = '$row_folios[0]' data-toggle = 'modal' data-target = '#modal-codigos' class='btn btn-primary' target='blank'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
  $cantidad = "<input type='text' name='cantidad_$i' id='cantidad_$i' class='form-control' style='width='100%' value='1'>";
	$renglon = "
		{
      \"consecutivo\":\"$i\",
      \"codigo\":\"$row[7]\",
      \"descripcion\":\"$row[0]\",
      \"exist\":\"$rowExistencia[0]\",
      \"um\":\"$row[8]\",
      \"cantidad\":\"$cantidad\",
      \"precio_venta\":\"$precio_venta\",
      \"opciones\":\"$link\"
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