<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$fecha_inicio = $_POST['fecha_inicial'];
$fecha_fin = $_POST['fecha_final'];

$cadenaCheques = "SELECT DISTINCT(ban_solpag.soli_numch), RTRIM(ctb_polizas_cheques.pchc_benef), ctb_polizas_cheques.pchn_monto, ban_solpag.soln_estatus
                  FROM ban_solpag INNER JOIN CTB_POLIZAS_CHEQUES ON ban_solpag.soli_numch = ctb_polizas_cheques.pchc_numero AND ban_solpag.benc_rfc=ctb_polizas_cheques.pchc_rfc
                  WHERE sold_fecch >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
                  AND sold_fecch < TRUNC (TO_DATE ('$fecha_fin', 'YYYY/MM/DD')) + 1
                  GROUP BY ban_solpag.soli_numch, RTRIM(ctb_polizas_cheques.pchc_benef), ctb_polizas_cheques.pchn_monto, ban_solpag.soln_estatus
                  ORDER BY soli_numch ASC";
$consultaCheques = oci_parse($conexion_central, $cadenaCheques);
oci_execute($consultaCheques);

$cuerpo ="";
$contador = 1;
while ($rowCheques=oci_fetch_row($consultaCheques)) {
  if($rowCheques[3]=='5'){
    $desc_cheque = ' ** CANCELADO ** '.$rowCheques[1];
    $monto = '0';
  }else{
    $desc_cheque = $rowCheques[1];
    $monto = $rowCheques[2];
  }
  $renglon = "
  {
    \"conteo\": \"$contador\",
    \"numero_cheque\": \"$rowCheques[0]\",
    \"proveedor\": \"$desc_cheque\",
    \"monto\": \"$monto\"
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
