<?php
include '../global_seguridad/verificar_sesion.php';
$id_receta = $_POST['id_receta'];
$cadenaReceta = "SELECT codigo_receta, nombre_receta, ieps, rendimiento, costo_operativo, margen_sugerido FROM cp_recetas WHERE id = '$id_receta'";
$consultaReceta = mysqli_query($conexion,$cadenaReceta);
$rowReceta = mysqli_fetch_array($consultaReceta);

$array = array(
  $rowReceta[0],
  $rowReceta[1],
  $rowReceta[2],
  $rowReceta[3],
  $rowReceta[4],
  $rowReceta[5]
);

$array = json_encode($array);
echo $array;
?>