<?php
include '../global_seguridad/verificar_sesion.php';
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

$cadenaTotal = "SELECT FORMAT(SUM(gasto),2) FROM gastos_sistemas where fecha_movimiento between '$fecha_inicio' and '$fecha_fin'";
$consultaTotal = mysqli_query($conexion, $cadenaTotal);
$rowTotal = mysqli_fetch_array($consultaTotal);

$total ="$ ".$rowTotal[0];

$array = array(
  $total
);

$array_datos = json_encode($array);
echo $array_datos;
?>