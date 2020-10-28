<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';



$cadena_detalle = "SELECT
                DISTINCT(artc.artc_articulo) articulo,
                lista.artc_descripcion,
                COUNT(artc.artc_articulo) cantidad,
                FAM.FAMC_DESCRIPCION,
                artc.ticn_folio,
                TO_CHAR(tkt.TICD_FECHAHORAVENTA, 'DD/MM/YYYY') Fecha,
                TO_CHAR(tkt.TICD_FECHAHORAVENTA, 'hh24:mi:ss') Hora
                FROM pv_articulosticket artc 
                INNER JOIN pv_tickets tkt ON tkt.ticc_sucursal = artc.ticc_sucursal
                INNER JOIN com_articulos lista ON artc.artc_articulo = lista.artc_articulo
                INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = lista.ARTC_FAMILIA
                AND tkt.ticn_folio = artc.ticn_folio
                wHERE tkt.TICN_AAAAMMDDVENTA = '$fecha'
                AND artc.ticn_aaaammddventa = '$fecha'
                AND artc.ticc_sucursal = '$sucursal'
                AND tkt.TICC_SUCURSAL = '$sucursal'
                GROUP BY artc.artc_articulo, artc.ticn_folio, lista.artc_descripcion, tkt.TICD_FECHAHORAVENTA, tkt.TICD_FECHAHORAVENTA, FAM.FAMC_DESCRIPCION
                ORDER BY artc.ticn_folio asc";
$st = oci_parse($conexion_central, $cadena_detalle);
	  oci_execute($st);
$cuerpo ="";
while ($row_detalle = oci_fetch_row($st)) {
    $escape_desc = mysqli_real_escape_string($conexion, $row_detalle[1]);
	$renglon = "
	{
		\"codigo\": \"$row_detalle[0]\",
		\"descripcion\": \"\",
		\"cantidad\": \"$row_detalle[2]\",
		\"familia\": \"$row_detalle[3]\",
		\"operacion\": \"$row_detalle[4]\",
		\"fecha\": \"$row_detalle[5]\",
		\"hora\": \"$row_detalle[6]\"
	},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
//echo $cadena_cartas;
echo $tabla;
?>