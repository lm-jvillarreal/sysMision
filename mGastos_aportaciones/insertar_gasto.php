<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
//$anio = date("Y");
$anio = '2019';

$ide_registro = $_POST['ide_registro'];
$proveedor = $_POST['proveedor'];
$concepto = $_POST['concepto'];
$comentarios = $_POST['comentarios'];
$importe = $_POST['total'];
$iva = $_POST['iva'];
$retencion = $_POST['retencion'];
$total = $importe+$iva;
$total = $total-$retencion;

$cadena_proveedor = "SELECT PROC_NOMBRE FROM CXP_PROVEEDORES WHERE PROC_CVEPROVEEDOR = '$proveedor'";
$consulta_proveedor = oci_parse($conexion_central, $cadena_proveedor);
oci_execute($consulta_proveedor);
$row_proveedor = oci_fetch_row($consulta_proveedor);

if($ide_registro==""){
  $cadena_gasto = "INSERT INTO gastos_aportaciones (importe, iva, retencion, total, cve_proveedor, nombre_proveedor, concepto, comentarios, anio, estatus, fecha, hora, activo, usuario) VALUES ('$importe', '$iva', '$retencion', '$total', '$proveedor', '$row_proveedor[0]', '$concepto', '$comentarios', '$anio', '1', '$fecha','$hora','1','$id_usuario')";
}else{
  $cadena_gasto = "UPDATE gastos_aportaciones SET importe='$importe', iva='$iva', retencion='$retencion', total='$total', cve_proveedor='$proveedor', nombre_proveedor = '$row_proveedor[0]', concepto='$concepto', comentarios = '$comentarios' WHERE id = '$ide_registro'";
}
$insertar_gasto = mysqli_query($conexion, $cadena_gasto);

echo "ok";
?>