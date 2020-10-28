<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("H:i:s");

$folio_registro = $_POST['folio_registro'];
$folio_descripcion = $_POST['folio_descripcion'];
$artc_articulo = $_POST['articulo'];


$cadena_consulta = "SELECT 
(SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM =1) AS Departamento,
FAM.FAMC_DESCRIPCION,
COM_ARTICULOS.ARTC_ARTICULO, 
COM_ARTICULOS.ARTC_DESCRIPCION
FROM COM_ARTICULOS
INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
WHERE com_articulos.artc_articulo = '$artc_articulo'";

$st = oci_parse($conexion_central, $cadena_consulta);
oci_execute($st);
$row_producto = oci_fetch_row($st);

$departamento = $row_producto[0];
$familia = $row_producto[1];
$descripcion = $row_producto[3];

$cadena_insertar = "INSERT INTO monitoreo_teoricos (folio, folio_desc, artc_articulo, artc_descripcion, artc_familia, artc_depto, fecha, hora, activo, usuario)VALUES('$folio_registro', '$folio_descripcion', '$artc_articulo', '$descripcion', '$familia', '$departamento', '$fecha', '$hora', '1', '$id_usuario')";
$consulta_insertar=mysqli_query($conexion, $cadena_insertar);

$array = array(
  $descripcion
);

$array_datos = json_encode($array);
echo $array_datos;
?>