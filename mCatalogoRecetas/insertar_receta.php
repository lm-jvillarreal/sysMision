<?php
include '../global_seguridad/verificar_sesion.php';

$fecha = date("Y-m-d");
$hora = date("H:i:s");

$codigo = $_POST['codigo'];
$nombre_receta = $_POST['nombre_receta'];
$rendimiento = $_POST['rendimiento'];
$margen_operativo = $_POST['margen_operativo'];
$margen_sugerido = $_POST['margen_sugerido'];
$ieps = $_POST['ieps'];

$cadenaInsertar = "INSERT INTO cp_recetas (codigo_receta, nombre_receta, rendimiento, costo_operativo, margen_sugerido, fecha, hora, activo, usuario, ieps)VALUES('$codigo', '$nombre_receta', '$rendimiento', '$margen_operativo', '$margen_sugerido', '$fecha', '$hora', '1', '$id_usuario', '$ieps')";
$insertarReceta = mysqli_query($conexion, $cadenaInsertar);

$cadenaId = "SELECT MAX(id) FROM cp_recetas";
$consultaId = mysqli_query($conexion, $cadenaId);
$rowId = mysqli_fetch_array($consultaId);
echo $rowId[0];
?>