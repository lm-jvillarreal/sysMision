<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("H:i:s");

$id_le = $_GET['id'];
$cadena_libroEntrada = "SELECT id, id_proveedor, sucursal, numero_nota, numero_factura, orden_compra FROM libro_diario WHERE id = '$id_le'";
$consulta_libroEntrada = mysqli_query($conexion, $cadena_libroEntrada);
$row_libroEntrada = mysqli_fetch_array($consulta_libroEntrada);

$numero_proveedor = $row_libroEntrada[1];
$sucursal = $row_libroEntrada[2];
$numero_nota = $row_libroEntrada[3];
$numero_factura = $row_libroEntrada[4];
$id_orden = $row_libroEntrada[5];

$cadena_proveedor = "SELECT id FROM proveedores WHERE numero_proveedor = '$numero_proveedor'";
$consulta_proveedor = mysqli_query($conexion, $cadena_proveedor);
$row_proveedor = mysqli_fetch_array($consulta_proveedor);
$id_proveedor = $row_proveedor[0];

$cadena_oc = "SELECT orden_compra FROM orden_compra WHERE id = '$id_orden'";
$consulta_oc =  mysqli_query($conexion, $cadena_oc);
$row_oc = mysqli_fetch_array($consulta_oc);
$numero_orden = $row_oc[0];

$cadena_insertar = "INSERT INTO carta_faltante (id_orden, no_orden, no_factura, id_sucursal, fecha_elaboracion, hora_elaboracion, activo, usuario, id_proveedor, numero_proveedor)VALUES('$id_orden','$numero_orden','$numero_factura','$sucursal','$fecha','$hora','1','$id_usuario','$id_proveedor','$numero_proveedor')";
$insertar_cf = mysqli_query($conexion, $cadena_insertar);

echo "<script>location.href='carta_faltante.php?id=$id_orden'</script>";

?>