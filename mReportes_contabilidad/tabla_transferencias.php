<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$fecha_inicio = $_POST['fecha_inicial'];
$fecha_fin = $_POST['fecha_final'];

$cadenaCheques = "SELECT ban_solpag.soli_numch, RTRIM(ctb_polizas_tranferencias.ptrc_benef), ctb_polizas_tranferencias.ptrn_monto, TO_CHAR (ctb_polizas_tranferencias.PTRD_FECHA,'YYYY/MM/DD')
                  FROM ban_solpag INNER JOIN CTB_POLIZAS_TRANFERENCIAS ON ban_solpag.solc_indice = ctb_polizas_tranferencias.polc_indice
                  WHERE SOLN_ESTATUS != '5' 
                  AND sold_fecch >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
                  AND sold_fecch < TRUNC (TO_DATE ('$fecha_fin', 'YYYY/MM/DD')) + 1
                  ORDER BY soli_numch ASC";
$consultaCheques = oci_parse($conexion_central, $cadenaCheques);
oci_execute($consultaCheques);

$cuerpo ="";
$contador = 1;
while ($rowCheques=oci_fetch_row($consultaCheques)) {
  $renglon = "
  {
    \"conteo\": \"$contador\",
    \"numero_cheque\": \"$rowCheques[0]\",
    \"proveedor\": \"$rowCheques[1]\",
    \"monto\": \"$rowCheques[2]\",
    \"fecha\": \"$rowCheques[3]\"
  },";
$cuerpo = $cuerpo.$renglon;
$contador = $contador +1;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
