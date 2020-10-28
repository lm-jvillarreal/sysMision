<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$codigo = $_POST['codigo'];

$cadenaTraspasos = "SELECT
                    TRANS.TRAN_ID_CONSECUTIVO FOLIOTRANS,
                    TRANS.MODC_TIPOMOV MOV,
                    TRANS.TRAN_FOLIO_SALIDA FSALIDA,
                    TRANS.TRAN_FOLIO_ENTRADA FENTRADA,
                    TRANS.ALMN_ALMACEN ORIGEN,
                    TRANS.TRAN_ALMACEN_DESTINO DESTINO,
                    TO_CHAR(trans.trad_fecha_aut_entrada,'yyyy-mm-dd') FECHA,
                    TRANS.MODN_FOLIO,
                    RENG.RTRN_CANTIDAD_SALIDA,
			              RENG.RTRN_CANTIDAD_ENTRADA
                    FROM
                    INV_TRANSFERENCIAS TRANS INNER JOIN INV_RENGLONES_TRANSFERENCIA RENG ON TRANS.TRAN_ID_CONSECUTIVO = RENG.TRAN_ID_CONSECUTIVO
                    WHERE
                    TRANS.TRAN_ESTATUS = '3' 
                    AND RENG.ARTC_ARTICULO = '$codigo'
                    AND MODC_TIPOMOV = 'ETRANS'
                    ORDER BY trans.trad_fecha_aut_entrada DESC";

$consultaTraspasos = oci_parse($conexion_central, $cadenaTraspasos);
oci_execute($consultaTraspasos);
$cuerpo ="";
while ($rowTraspasos = oci_fetch_row($consultaTraspasos)) {
  $renglon = "
	{
		\"id\": \"$rowTraspasos[0]\",
    \"movimiento\": \"$rowTraspasos[1]\",
    \"folio_mov\": \"$rowTraspasos[7]\",
    \"folio_salida\": \"$rowTraspasos[2]\",
    \"cantidad_salida\": \"$rowTraspasos[8]\",
    \"folio_entrada\": \"$rowTraspasos[3]\",
    \"cantidad_entrada\": \"$rowTraspasos[9]\",
    \"origen\": \"$rowTraspasos[4]\",
    \"destino\": \"$rowTraspasos[5]\",
    \"fecha\": \"$rowTraspasos[6]\"
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
