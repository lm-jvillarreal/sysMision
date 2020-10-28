<?php
include '../global_seguridad/verificar_sesion.php';

$id_pregunta = $_POST['id_pregunta'];

$cadena_consulta = "SELECT id,pregunta FROM n_preguntas WHERE id = '$id_pregunta'";
$consulta = mysqli_query($conexion, $cadena_consulta);
$row      = mysqli_fetch_array($consulta);

echo $row[1];
?>