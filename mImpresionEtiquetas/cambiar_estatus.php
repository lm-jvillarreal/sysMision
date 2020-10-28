<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_impreso = date('Y-m-d H:i:s');
$id_solicitud = $_POST['id_solicitud'];

$cadena_total = "SELECT COUNT(id) FROM detalle_solicitud WHERE id_solicitud = '$id_solicitud'";
$consulta_total = mysqli_query($conexion, $cadena_total);
$row_total = mysqli_fetch_array($consulta_total);

$cadena_cero = "SELECT COUNT(id) FROM detalle_solicitud WHERE id_solicitud = '$id_solicitud' AND cantidad='0'";
$consulta_total = mysqli_query($conexion, $cadena_cero);
$row_cero = mysqli_fetch_array($consulta_total);

$calificacion = ($row_cero[0]*100)/$row_total[0];

$cadena_impreso = "UPDATE solicitud_etiquetas SET estatus = '2', fecha_impresion = '$fecha_impreso', usuario_imprime = '$id_usuario', calificacion = '$calificacion' WHERE id = '$id_solicitud'";
$consulta_impreso = mysqli_query($conexion,$cadena_impreso);

//Consulta de datos
$consulta_solicitud = mysqli_query($conexion,"SELECT nombre,(SELECT formatos_etiquetas.nombre FROM formatos_etiquetas WHERE solicitud_etiquetas.formato = formatos_etiquetas.id ) FROM solicitud_etiquetas WHERE id = '$id_solicitud'");
$row = mysqli_fetch_array($consulta_solicitud);
$title = $row[0].'-'.$row[1];
$consutla_calendario = mysqli_query($conexion,"SELECT folio FROM agenda WHERE title LIKE '$id_solicitud%'");
$row2 = mysqli_fetch_array($consutla_calendario);
$eliminar_evento = mysqli_query($conexion,"DELETE FROM agenda WHERE folio = '$row2[0]'");
echo "ok";
?>