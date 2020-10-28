<?php
include '../global_seguridad/verificar_sesion.php';
$id = $_POST['id'];
$cadenaComentario = "SELECT codigo_comentario FROM auditoria_pv WHERE id = '$id'";
$consultaComentario = mysqli_query($conexion,$cadenaComentario);
$rowComentario = mysqli_fetch_array($consultaComentario);

$array = array(
  $rowComentario[0]
);
$array_datos = json_encode($array);
echo $array_datos;
?>