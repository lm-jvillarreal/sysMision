<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$cod = $_POST['codigo_artc'];
$cadenaCod = "SELECT codigo FROM costos_cero WHERE id = '$cod'";
$consultaCod = mysqli_query($conexion, $cadenaCod);
$rowCod = mysqli_fetch_array($consultaCod);
$codigo = $rowCod[0];

$cadena_consulta = "SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$codigo'";
$st_desc = oci_parse($conexion_central, $cadena_consulta);
oci_execute($st_desc);
$row_desc = oci_fetch_row($st_desc);

$descripcion = "*** NO USAR *** ".$row_desc[0];
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$fecha_dos = date("d/M/y");
$hora=date ("h:i:s");

$stid = oci_parse($conexion_central, "UPDATE COM_ARTICULOS SET ARTN_ESTATUS = 2, ARTD_BAJA = '$fecha_dos', ARTC_DESCRIPCION = '$descripcion',ARTC_DESCRIPCION_LARGA = '$descripcion' WHERE ARTC_ARTICULO = '$codigo'");
oci_execute($stid);
oci_free_statement($stid);
oci_close($conexion_central);

$cadena_resuelve = "UPDATE costos_cero SET estatus = '3', articulo = '$descripcion', baja = '1' WHERE codigo = '$codigo'";
$consulta_resuelve = mysqli_query($conexion, $cadena_resuelve);
echo "ok";
