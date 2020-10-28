<?php
include '../global_settings/conexion_oracle.php';

$codigo = $_POST['codigo'];

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$cadena_lista = "SELECT prov.PROC_CVEPROVEEDOR, 
                TRIM(prov.PROC_NOMBRE), 
                artc.artc_articulo,
                artc.artc_descripcion,
                lst.alpn_precio,
                lst.alpn_precio_base,
                lst.alpn_pct_descuento_0_100,
                lst.alpn_pct_descuento2_0_100,
                lst.alpn_pct_descuento3_0_100,
                lst.alpn_pct_descuento4_0_100,
                lst.alpn_pct_descuento5_0_100
                FROM COM_ARTICULOSLISTAPRECIOS lst 
                INNER JOIN CXP_PROVEEDORES prov ON TRIM(lst.PROC_CVEPROVEEDOR) = TRIM(prov.PROC_CVEPROVEEDOR)
                INNER JOIN COM_ARTICULOS artc ON lst.artc_articulo = artc.artc_articulo 
                WHERE lst.ARTC_ARTICULO = '$codigo'";

$consulta_lista = oci_parse($conexion_central, $cadena_lista);
oci_execute($consulta_lista);
$cuerpo ="";
while ($row_lista = oci_fetch_row($consulta_lista)) {

	$renglon = "
	{
		\"cve_prov\": \"$row_lista[0]\",
		\"prov\": \"$row_lista[1]\",
		\"codigo\": \"$row_lista[2]\",
        \"descripcion\": \"$row_lista[3]\",
        \"costo\": \"$row_lista[4]\",
        \"costo_base\": \"$row_lista[5]\",
        \"desc1\": \"$row_lista[6]\",
        \"desc2\": \"$row_lista[7]\",
        \"desc3\": \"$row_lista[8]\",
        \"desc4\": \"$row_lista[9]\",
        \"desc5\": \"$row_lista[10]\"
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