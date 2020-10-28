<?php
include '../global_seguridad/verificar_sesion.php';
$id_ficha = $_POST['id_ficha'];
$cadenaMarcar = "UPDATE libro_diario SET tipo = '2' WHERE id='$id_ficha'";
$consultaMarcar = mysqli_query($conexion,$cadenaMarcar);
echo $cadenaMarcar;
?>