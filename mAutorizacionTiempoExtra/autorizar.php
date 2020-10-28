<?php
include '../global_seguridad/verificar_sesion.php';
$id = $_POST['id'];
$tiempo=$_POST['tiempo_aut'];



$cadena_verifica = "SELECT folio FROM tiempo_extra WHERE id = '$id'";
$consulta_verifica = mysqli_query($conexion, $cadena_verifica);



$cadena_modifica = "UPDATE tiempo_extra SET folio = '1', tiempo_aut='$tiempo' WHERE id = '$id'";
$modifica_estado = mysqli_query($conexion, $cadena_modifica);

 echo "ok";
 ?>