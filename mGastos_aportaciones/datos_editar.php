<?php
include '../global_seguridad/verificar_sesion.php';

$id_registro = $_POST['id_registro'];

$cadenaGastos = "SELECT importe, iva, retencion, comentarios, cve_proveedor, nombre_proveedor, concepto, id FROM gastos_aportaciones WHERE id = '$id_registro'";
$consultaGastos = mysqli_query($conexion,$cadenaGastos);
$rowGastos = mysqli_fetch_array($consultaGastos);

$array = array(
  $rowGastos[0], //Importe
  $rowGastos[1], //IVA
  $rowGastos[2], //retencion
  $rowGastos[3], //Comentarios
  $rowGastos[4], //cve proveedor
  $rowGastos[5], //nombre proveedor
  $rowGastos[6], //Concepto
  $rowGastos[7]
);

$array_datos = json_encode($array);
echo $array_datos;
?>