<?php
include '../global_settings/conexion_oracle.php';

$codigo = $_POST['codigo'];

$cadena_consulta = "SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$codigo'";

//echo $cadena_consulta;
$st = oci_parse($conexion_central, $cadena_consulta);
oci_execute($st);
$row_articulo = oci_fetch_row($st);

$array = array($row_articulo[0]);

$array_datos = json_encode($array);
echo "$array_datos"; 
//echo "$cadena_consulta";
?>