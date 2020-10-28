<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fecha = date("Y-m-d");
$hora = date("H:i:s");

$id_receta = $_POST['id_receta'];
$codigo = $_POST['codigo'];
$nombre_receta = $_POST['nombre_receta'];
$ieps = $_POST['ieps'];
$rendimiento = $_POST['rendimiento'];
$margen_operativo = $_POST['margen_operativo'];
$margen_sugerido = $_POST['margen_sugerido'];

$cadenaActualizar = "UPDATE cp_recetas SET codigo_receta = '$codigo', nombre_receta = '$nombre_receta', ieps='$ieps', rendimiento = '$rendimiento', costo_operativo = '$margen_operativo', margen_sugerido = '$margen_sugerido' WHERE id = '$id_receta'";
$actualizarReceta = mysqli_query($conexion, $cadenaActualizar);
echo "ok";
?>