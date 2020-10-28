<?php
include "../global_seguridad/verificar_sesion.php";

$id_registro = $_POST['id_registro'];

$cadena_consulta = "SELECT id, sorteo, anio, tiraje_boletos, monto_boleto, boletos_block, fecha_inicio, fecha_fin FROM configuracion_sorteos WHERE id = '$id_registro'";
$consulta_registro = mysqli_query($conexion, $cadena_consulta);
$row_registro = mysqli_fetch_array($consulta_registro);

$array = array(
    $row_registro[0],
    $row_registro[1],
    $row_registro[2],
    $row_registro[3],
    $row_registro[4],
    $row_registro[5],
    $row_registro[6],
    $row_registro[7]
);
$array_datos = json_encode($array);
echo $array_datos;
?>