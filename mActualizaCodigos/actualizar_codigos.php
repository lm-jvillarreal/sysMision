<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$fecha = date("Y-m-d H:i:s");

$cadenaFecha = "SELECT DATE_FORMAT(MAX(fecha),'%d/%m/%Y') FROM productos";
$consultaFecha = mysqli_query($conexion,$cadenaFecha);
$rowFecha = mysqli_fetch_array($consultaFecha);

$cadenaCodigos = "SELECT ARTC_ARTICULO, ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTD_ALTA >= TO_DATE('$rowFecha[0]', 'DD/MM/YY')";
//echo $cadenaCodigos;
$consulta_codigos = oci_parse($conexion_central, $cadenaCodigos);
oci_execute($consulta_codigos);

while ($row_codigos = oci_fetch_row($consulta_codigos)) {
  $cadenaValidar = "SELECT * FROM productos WHERE codigo_producto = '$row_codigos[0]'";
  $validar = mysqli_query($conexion,$cadenaValidar);
  $rowValidar = mysqli_fetch_array($validar);
  $conteo = count($rowValidar[0]);
  if($conteo==0){
    $cadenaInsertar ="INSERT INTO productos(codigo_producto, descripcion, fecha)VALUES('$row_codigos[0]','$row_codigos[1]','$fecha')";
    $insertar = mysqli_query($conexion, $cadenaInsertar);
  }
}
echo "ok";
?>