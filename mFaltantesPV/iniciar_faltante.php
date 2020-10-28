<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$folio = $_POST['folio'];

$cadena_inicia = "UPDATE faltantes_pasven SET estatus = '1' WHERE folio = '$folio'";
$consulta_inicia =  mysqli_query($conexion, $cadena_inicia);
echo "ok";
?>