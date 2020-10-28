<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$fecha_libera = date("Y-m-d h:i:s");
$hora=date ("h:i:s");

$id_cambio = $_POST['id_cambio'];
$folio = (!empty($_POST['folio']))?$_POST['folio']:"0";

$cadena_valida = "SELECT folio FROM bitacora_cambios WHERE id = '$id_cambio'";
$consulta_valida = mysqli_query($conexion, $cadena_valida);
$row_valida = mysqli_fetch_array($consulta_valida);

if($row_valida[0]==$folio){
    $validado = '1';
    $mensaje = 'validado';
}else{
    $validado = '0';
    $mensaje = 'no_validado';
}
$cadena_libera = "UPDATE bitacora_cambios SET liberado = '1', codigo_valida = '$folio', validado = '$validado', usuario_libera = '$id_usuario', fecha_libera = '$fecha_libera' WHERE id = '$id_cambio'";
$consulta_libera = mysqli_query($conexion, $cadena_libera);
echo $mensaje;
?>