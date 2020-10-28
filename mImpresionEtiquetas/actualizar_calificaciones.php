<?php
include '../global_seguridad/verificar_sesion.php';

$cadena_consulta = "SELECT id FROM solicitud_etiquetas WHERE estatus = '2'";
$consulta = mysqli_query($conexion, $cadena_consulta);

while($row_id = mysqli_fetch_array($consulta)){

    $cadena_total = "SELECT COUNT(id) FROM detalle_solicitud WHERE id_solicitud = '$row_id[0]'";
    $consulta_total = mysqli_query($conexion, $cadena_total);
    $row_total = mysqli_fetch_array($consulta_total);

    $cadena_cero = "SELECT COUNT(id) FROM detalle_solicitud WHERE id_solicitud = '$row_id[0]' AND cantidad='0'";
    $consulta_total = mysqli_query($conexion, $cadena_cero);
    $row_cero = mysqli_fetch_array($consulta_total);

    $calificacion = ($row_cero[0]*100)/$row_total[0];

    $cadena_impreso = "UPDATE solicitud_etiquetas SET  calificacion = '$calificacion' WHERE id = '$row_id[0]'";
    $consulta_impreso = mysqli_query($conexion,$cadena_impreso);
}
?>