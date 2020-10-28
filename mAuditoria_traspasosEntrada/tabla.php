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
	$cadena_sucursal = "SELECT id, nombre FROM sucursales WHERE id = '$row_traspasos[3]'";
	$consulta_sucursal = mysqli_query($conexion, $cadena_sucursal);
	$row_sucursal = mysqli_fetch_array($consulta_sucursal);

	$cadena_sucursal = "SELECT id, nombre FROM sucursales WHERE id = '$row_traspasos[6]'";
	$consulta_sucursal = mysqli_query($conexion, $cadena_sucursal);
	$row_sucursal_envia = mysqli_fetch_array($consulta_sucursal);

	$detalles = "<center><a href='#'' data-id = '$row_traspasos[0]' data-toggle='modal' data-target='#modal-default' class='btn btn-success'>Visualizar</a></center>";

	$renglon = "
		{
		\"id_trans\": \"$row_traspasos[0]\",
		\"folio_salida\": \"$row_traspasos[1]\",
	   \"folio_entrada\": \"$row_traspasos[2]\",
	   \"sucursal\": \"$row_sucursal[1]\",
	   \"sucursal_envia\": \"$row_sucursal_envia[1]\",
	   \"fecha_captura\": \"$row_traspasos[4]\",
	   \"detalles\": \"$detalles\"
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