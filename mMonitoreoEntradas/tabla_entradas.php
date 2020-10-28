<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha = date('d/m/Y');
$hora=date ("h:i:s");

$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$sucursal = $_POST['sucursal'];

if(empty($sucursal)){
  $filtro_sucursal = "";
}else{
  $filtro_sucursal = " AND m.ALMN_ALMACEN = '$sucursal'";
}

$cadenaEntradas = "SELECT 
m.modn_folio,
(SELECT CONCAT(PROC_CVEPROVEEDOR,TRIM(PROC_NOMBRE)) FROM CXP_PROVEEDORES WHERE TRIM(PROC_CVEPROVEEDOR) = TRIM(m.movc_cveproveedor)) Proveedor,
e.ordn_orden,
(SELECT ORDN_ESTATUS FROM com_ordenes_compra WHERE ordn_orden = e.ordn_orden) estatus,
e.entc_factura,
TO_CHAR(m.movd_fechaelaboracion,'DD/MM/YYYY') Fecha,
m.almn_almacen
FROM INV_MOVIMIENTOS m INNER JOIN COM_ENTRADAS e
ON m.movc_notaentrada = e.entn_entrada
AND m.almn_almacen = e.almn_almacen
WHERE m.MODC_TIPOMOV = 'ENTCOC'
AND m.MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicial','YYYY-MM-DD'))
AND m.MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_final', 'YYYY-MM-DD'))+1".$filtro_sucursal;
$consultaEntradas = oci_parse($conexion_central, $cadenaEntradas);
oci_execute($consultaEntradas);

$cuerpo ="";

while ($rowEntradas = oci_fetch_row($consultaEntradas)) {
  $estatus = ($rowEntradas[3]!='5')? "<center><span class='label label-warning'>Surtido parcial</span></center>":"<center><span class='label label-success'>Surtido completo</span></center>";
  $ver = "<center><a href='#' data-folio = '$rowEntradas[2]' data-toggle = 'modal' data-target = '#modal-codigos' class='btn btn-primary' target='blank'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
	$renglon = "
		{
      \"sucursal\": \"$rowEntradas[6]\",
      \"folio_movimiento\": \"$rowEntradas[0]\",
      \"proveedor\": \"$rowEntradas[1]\",
      \"orden_compra\": \"$rowEntradas[2]\",
      \"estatus\": \"$estatus\",
      \"factura\": \"$rowEntradas[4]\",
      \"fecha\": \"$rowEntradas[5]\",
      \"opciones\": \"$ver\"
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