<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fecha = date("Y-m-d");
$hora = date("H:i:s");

$id_carta = $_POST['id_carta'];
$articulo= $_POST['articulo'];
$cadenaConsulta = "INSERT INTO detalle_carta_faltante (id_carta_faltante, descripcion, fecha, hora, activo, usuario)VALUES('$id_carta','$articulo','$fecha','$hora','1','$id_usuario')";
$insertarArticulo = mysqli_query($conexion,$cadenaConsulta);
echo "ok";
?>