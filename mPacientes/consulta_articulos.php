<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d H:i:s"); 
$hora=date ("H:i:s");

$articulo =  strtoupper($_POST['articulo']);

$cadena_consulta = "SELECT 
(SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM =1) AS Departamento,
 FAM.FAMC_DESCRIPCION,
 COM_ARTICULOS.ARTC_ARTICULO, 
 COM_ARTICULOS.ARTC_DESCRIPCION
FROM COM_ARTICULOS
INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
WHERE (FAM.FAMC_FAMILIAPADRE = '37' OR FAM.FAMC_FAMILIAPADRE = '11')
AND COM_ARTICULOS.ARTN_ESTATUS = '1'
AND COM_ARTICULOS.ARTC_DESCRIPCION LIKE '%$articulo%'";

$st = oci_parse($conexion_central, $cadena_consulta);
oci_execute($st);

$cuerpo ="";
while ($row_producto = oci_fetch_row($st)) {

    $cadena_cantidad = "SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 2, '$row_producto[2]') FROM dual";
    $st_cantidad = oci_parse($conexion_central, $cadena_cantidad);
    oci_execute($st_cantidad);
    $row_cantidad = oci_fetch_row($st_cantidad);

	$renglon = "
	{
		\"codigo\": \"$row_producto[2]\",
		\"descripcion\": \"$row_producto[3]\",
		\"cantidad\": \"$row_cantidad[0]\"
	},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
//echo $cadena_cartas;
echo $tabla;
?>