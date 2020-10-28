<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$id_registro= $_POST['id_registro'];
$h_pagar=$_POST['h_pagar'];

$cadena_verifica = "SELECT folio, tiempo_aut FROM tiempo_extra WHERE id = '$id_registro'";

$consulta_verifica = mysqli_query($conexion, $cadena_verifica);
$row_verifica = mysqli_fetch_array($consulta_verifica);


$cadena_modifica = "UPDATE tiempo_extra SET  tiempo_aut = '$h_pagar', folio = '1' WHERE id = '$id_registro'";
$modifica_estado = mysqli_query($conexion, $cadena_modifica);

 echo "ok";
 ?>