<?php
include '../global_settings/conexion.php';
include '../global_settings/conexion_oracle.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$fecha_inicio = (!isset($_POST['fecha_inicial'])) ? $fecha : $_POST['fecha_inicial'];
$fecha_fin = (!isset($_POST['fecha_final'])) ? $fecha : $_POST['fecha_final'];
$filtro_sucursal = ($_POST['sucursal']=="") ? "" : " AND ALMN_ALMACEN ='".$_POST['sucursal']."'";
$datos=array();

$cadena_traspasos = "SELECT
		TRAN_ID_CONSECUTIVO,
		TRAN_FOLIO_SALIDA,
		TRAN_FOLIO_ENTRADA,
		ALMN_ALMACEN,
	  TO_CHAR(TRAD_FECHA_CAPTURA,'dd/mm/yyyy'),
		TRAN_ESTATUS,
		TRAN_ALMACEN_DESTINO
	FROM
		INV_TRANSFERENCIAS 
	WHERE
		TRAD_FECHA_CAPTURA >= trunc(
		TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
		AND TRAD_FECHA_CAPTURA < trunc(
		TO_DATE( '$fecha_fin', 'YYYY/MM/DD' )) + 1 
		AND MODN_FOLIO IS NULL AND ( TRAN_ESTATUS = '1' OR TRAN_ESTATUS='2')".$filtro_sucursal." ORDER BY TRAD_FECHA_CAPTURA ASC";
$cuerpo ="";

$consulta_traspasos = oci_parse($conexion_central, $cadena_traspasos);
                      oci_execute($consulta_traspasos);
while ($row_traspasos = oci_fetch_row($consulta_traspasos)) {
	$cadena_detalle = "SELECT
				INV_RENGLONES_TRANSFERENCIA.ARTC_ARTICULO,
				PV_ARTICULOS.ARTC_DESCRIPCION,
				INV_RENGLONES_TRANSFERENCIA.RTRN_CANTIDAD_SALIDA,
				INV_RENGLONES_TRANSFERENCIA.RTRN_CANTIDAD_ENTRADA 
			FROM
				INV_RENGLONES_TRANSFERENCIA
				INNER JOIN PV_ARTICULOS ON INV_RENGLONES_TRANSFERENCIA.ARTC_ARTICULO = PV_ARTICULOS.ARTC_ARTICULO 
			WHERE
				TRAN_ID_CONSECUTIVO = '$row_traspasos[0]'";
  $consulta_detalle = oci_parse($conexion_central, $cadena_detalle);
  oci_execute($consulta_detalle);
  while($row = oci_fetch_row($consulta_detalle))
    {
      array_push($datos,array(
        'codigo'=>$row[0],
        'descripcion'=>$row[1],
        'salida'=>$row[2],
        'entrada'=>$row[3]
      ));
    }
}
echo utf8_encode(json_encode($datos));
?>