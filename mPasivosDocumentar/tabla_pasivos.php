<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$fecha_inicio = $_POST['fecha_inicial'];
$fecha_fin = $_POST['fecha_final'];

$cadenaPasivos = "SELECT  
                  proc_cveproveedor,
                  (SELECT TRIM(PROC_NOMBRE) FROM CXP_PROVEEDORES WHERE TRIM(PROC_CVEPROVEEDOR)=TRIM(cxp_remisiones.proc_cveproveedor)) nom,
                  cxpc_numfact,
                  cxpc_descrfactura,
                  cxpn_importe,
                  cxpn_iva,
                  cxpd_fechafact
                  FROM cxp_remisiones WHERE cxpn_estatus = '1'
                  AND cxpd_fechafact >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY-MM-DD'))
                  AND cxpd_fechafact < TRUNC (TO_DATE ('$fecha_fin', 'YYYY-MM-DD'))+1";
$consultaPasivos = oci_parse($conexion_central, $cadenaPasivos);
oci_execute($consultaPasivos);

$cuerpo ="";
$contador = 1;
while ($rowPasivos=oci_fetch_row($consultaPasivos)) {
  $renglon = "
  {
    \"clave_proveedor\": \"$rowPasivos[0]\",
    \"proveedor\": \"$rowPasivos[1]\",
    \"remision\": \"$rowPasivos[2]\",
    \"descripcion\": \"$rowPasivos[3]\",
    \"importe\": \"$rowPasivos[4]\",
    \"iva\": \"$rowPasivos[5]\",
    \"fecha\": \"$rowPasivos[6]\"
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
