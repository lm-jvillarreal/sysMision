<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
date_default_timezone_set("America/Monterrey");

$fecha_baja = date("Y-m-d");
$hora_baja = date("H:i:s");
$fecha = date("d/M/Y");
$folio_oferta = $_POST['folio_oferta'];
$artc_articulo = $_POST['artc_articulo'];

$cadenaUpdate = "UPDATE PV_ARTICULOS_OFERTA SET ARON_BAJA_SN ='1', arod_fecha_baja = '$fecha' WHERE AROC_ARTICULO = '$artc_articulo' AND ARON_BAJA_SN = '0' AND COON_ID_OFERTA = '$folio_oferta'";
$stid = oci_parse($conexion_central, $cadenaUpdate);
oci_execute($stid);
oci_free_statement($stid);
oci_close($conexion_central);

$cadenaBaja = "INSERT INTO bitacora_bajaofertas (folio_oferta, artc_articulo, fecha, hora, activo, usuario)VALUES('$folio_oferta','$artc_articulo','$fecha_baja','$hora_baja','1','$id_usuario')";
$bajaOferta = mysqli_query($conexion,$cadenaBaja);
echo "ok";
