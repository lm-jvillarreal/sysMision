<?php
include '../global_seguridad/verificar_sesion.php';

$codigo_prod = $_POST['codigo_prod'];
$desc_prod = $_POST['desc_prod'];
$catalogo = $_POST['catalogo'];

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

$cadena_consulta = "SELECT nombre_catalogo  FROM cp_catalogos WHERE id = '$catalogo'";
$consulta_catalogo = mysqli_query($conexion, $cadena_consulta);
$row_catalogo = mysqli_fetch_array($consulta_catalogo);

$cadena_insertar = "INSERT INTO cp_catalogos(no_catalogo, nombre_catalogo, cve_producto, desc_producto, familia_producto, sucursal, fecha, hora, activo, usuario)VALUES('$catalogo', '$row_catalogo[0]', '$codigo_prod', '$desc_producto', '$id_sede', '$fecha', '$hora', '1', '$id_usuario')";
?>