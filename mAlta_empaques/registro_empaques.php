<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$parametro = $_POST['parametro'];
if($parametro == "vacio"){
  $cadena_lista = "SELECT e.artc_articulo, artc.artc_descripcion, e.arec_descripcion, e.aren_cantidad FROM inv_articulos_empaque e INNER JOIN com_articulos artc ON e.artc_articulo = artc.artc_articulo WHERE rownum = 0";
}elseif($parametro == "lleno"){
  $cadena_lista = "SELECT e.artc_articulo, artc.artc_descripcion, e.arec_descripcion, e.aren_cantidad FROM inv_articulos_empaque e INNER JOIN com_articulos artc ON e.artc_articulo = artc.artc_articulo";
}
$consulta_lista = oci_parse($conexion_central, $cadena_lista);
oci_execute($consulta_lista);

$cuerpo ="";
while($row_lista = oci_fetch_row($consulta_lista)){
  $descripcion=mysqli_real_escape_string($conexion,$row_lista[1]);
  $renglon = "
  {
    \"codigo\": \"$row_lista[0]\",
    \"descripcion\": \"$descripcion\",
    \"unidad_empaque\": \"$row_lista[2]\",
    \"cantidad\": \"$row_lista[3]\"
  },";
  $cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>