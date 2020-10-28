<?php
include "../global_seguridad/verificar_sesion.php";

date_default_timezone_set('America/Monterrey');
$anio = date("Y");
$fecha = date("Y-m-d");
$hora = date("H:i:s");


$sucursal = $_POST['sucursal'];
$folio_inicial = $_POST['folio_inicial'];
$folio_final = $_POST['folio_final'];
$cantidad_blocks = $_POST['cantidad_blocks'];
$porcentaje = $_POST['porcentaje'];

$cadena_sorteo = "SELECT id FROM configuracion_sorteos WHERE activo = '1' and anio = '$anio'";
$consulta_sorteo = mysqli_query($conexion,$cadena_sorteo);
$row_sorteo = mysqli_fetch_array($consulta_sorteo);
$id_sorteo = $row_sorteo[0];

$cadena_baja = "UPDATE dispersion_boletos SET activo = '0' WHERE sucursal = '$sucursal'";
//$baja_dispersion = mysqli_query($conexion, $cadena_baja);

$cadena_insertar = "INSERT INTO dispersion_boletos (folio_inicial, folio_final, anio, sucursal, cant_blocks, porcentaje, fecha, hora, activo, usuario, id_sorteo)VALUES('$folio_inicial', '$folio_final', '$anio', '$sucursal', '$cantidad_blocks', '$porcentaje', '$fecha', '$hora', '0', '$id_usuario', '$id_sorteo')";
$insertar_dispersion = mysqli_query($conexion, $cadena_insertar);
echo "ok";
?>