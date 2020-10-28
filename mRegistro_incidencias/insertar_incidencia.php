<?php
include '../global_seguridad/verificar_sesion.php';
$fecha = date("Y-m-d");
$hora = date("h:i:s");
$sucursal = $_POST['sucursal'];
$momento = $_POST['momento'];
$descripcion = $_POST['desc_incidencia'];
$categoria = $_POST['categoria'];
$incidencia = $_POST['incidencia'];
$area = $_POST['areas'];
$fecha_incidencia = $_POST['fecha'];
$detalle = $_POST['comentario'];
$url = $_POST['url'];

$cadena_insertar = "INSERT INTO registroIncidencias_vidvig (id_sucursal, momento, descripcion, id_categoria, tipo_incidencia, id_area, fecha_incidencia, detalle, fecha, hora, activo, usuario, url_video)VALUES('$sucursal', '$momento', '$descripcion', '$categoria', '$incidencia', '$area', '$fecha_incidencia', '$detalle', '$fecha', '$hora', '1', '$id_usuario', '$url')";
$insertar_incidencia = mysqli_query($conexion, $cadena_insertar);

echo $cadena_insertar;
?>