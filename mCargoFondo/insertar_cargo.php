<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date("H:i:s");

$folio_oferta = $_POST['folio_oferta'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$codigo = $_POST['codigo'];
$descripcion= $_POST['descripcion'];
$proveedor = $_POST['proveedor'];
$cantidad = $_POST['cantidad'];
$comprador = $_POST['comprador'];

$cadenaInsertar = "INSERT INTO cargos_fondos(folio_oferta, articulo, descripcion, fecha_inicio, fecha_fin, tipo, cantidad, sucursal, fecha, hora, activo, usuario, id_comprador, proveedor)VALUES('$folio_oferta', '$codigo', '$descripcion', '$fecha_inicio', '$fecha_fin', 'CANTIDAD', '$cantidad', '$id_sede', '$fecha', '$hora', '1', '$id_usuario', '$comprador' ,'$proveedor')";
$consultaInsertar = mysqli_query($conexion, $cadenaInsertar);
echo "ok";
?>