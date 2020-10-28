<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$datos=array();
$cadenaFecha = "SELECT DATE_FORMAT(MAX(fecha),'%d/%m/%Y') FROM productos";
$consultaFecha = mysqli_query($conexion,$cadenaFecha);
$rowFecha = mysqli_fetch_array($consultaFecha);

$cadenaCodigos = "SELECT ARTC_ARTICULO, ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTD_ALTA >= TO_DATE('$rowFecha[0]', 'DD/MM/YY')";
//echo $cadenaCodigos;
$consulta_codigos = oci_parse($conexion_central, $cadenaCodigos);
oci_execute($consulta_codigos);
$n=1;
$cuerpo="";
while ($row_codigos = oci_fetch_row($consulta_codigos)) {
  $cadenaValidar = "SELECT * FROM productos WHERE codigo_producto = '$row_codigos[0]'";
  $validar = mysqli_query($conexion,$cadenaValidar);
  $rowValidar = mysqli_fetch_array($validar);
  $conteo = count($rowValidar[0]);
  if($conteo==0){
    array_push($datos,array(
      'numero'=>$n,
      'codigo'=>$row_codigos[0],
      'descripcion'=>$row_codigos[1]
    ));
    $n=$n+1;
  }
}
echo utf8_encode(json_encode($datos));
?>