<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
//$anio = date("Y");
$anio = '2020';

$fecha_afectacion = $_POST['fecha_afectacion'];
$movimiento = $_POST['movimiento'];
$folio = $_POST['folio'];
$valor = $_POST['valor'];
$concepto = $_POST['concepto'];
$id_comprador = $_POST['id_comprador'];
$proveedor = $_POST['proveedor'];
$comentario = $_POST['comentarios'];
$sucursal = $_POST['sucursal'];
$metodo_pago = $_POST['metodo_pago'];
$referencia = $_POST['referencia'];

$cadena_proveedor = "SELECT PROC_NOMBRE FROM CXP_PROVEEDORES WHERE PROC_CVEPROVEEDOR = '$proveedor'";
$consulta_proveedor = oci_parse($conexion_central, $cadena_proveedor);
oci_execute($consulta_proveedor);
$row_proveedor = oci_fetch_row($consulta_proveedor);

$cadena_aportacion = "INSERT INTO aportaciones (tipo_movimiento, folio_movimiento, fecha_afectacion, id_sucursal, concepto, anio, id_comprador, cve_proveedor, nombre_proveedor, total, comentarios, fecha, hora, activo, usuario, metodo_pago, referencia)VALUES('$movimiento','$folio','$fecha_afectacion','$sucursal','$concepto','$anio','$id_comprador','$proveedor','$row_proveedor[0]','$valor','$comentario','$fecha','$hora','1','$id_usuario','$metodo_pago','$referencia')";

$inserta_aportacion = mysqli_query($conexion, $cadena_aportacion);

echo "ok";
?>