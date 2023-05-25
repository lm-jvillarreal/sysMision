<?php
include '../global_settings/conexion.php';
$resultado = array();
$fechahora=date("Y-m-d H:i:s");
$sucursal=$_POST['sucursal'];
$cadenaConteo="SELECT CONTEO_CLIENTES FROM covid_conteo_clientes WHERE SUCURSAL='$sucursal'";
$conteo=mysqli_query($conexion,$cadenaConteo);
$rowConteo=mysqli_fetch_array($conteo);
$cadenaHistorial="INSERT INTO historial_conteoCovid (FECHAHORA, SUCURSAL, CONTEO)VALUES('$fechahora','$sucursal','$rowConteo[0]')";
$insertar=mysqli_query($conexion,$cadenaHistorial);

array_push($resultado,array(
    'resultado'=>"ok"
  ));
echo utf8_encode(json_encode($resultado));
?>