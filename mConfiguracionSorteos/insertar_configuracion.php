<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set("America/Monterrey");
$anio = date("Y");
$fecha = date("Y-m-d");
$hora = date("H:i:s");

$ide = $_POST['ide'];
$sorteo = $_POST['sorteo'];
$tiraje = $_POST['tiraje'];
$cant_boleto = $_POST['cant_boleto'];
$boletos_block = $_POST['boletos_block'];
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_fin = $_POST['fecha_final'];

if(empty($ide)){
    $cadena_insertar = "INSERT INTO configuracion_sorteos (sorteo, anio, tiraje_boletos, monto_boleto, boletos_block, fecha, hora, activo, usuario, fecha_inicio, fecha_fin)VALUES('$sorteo', '$anio', '$tiraje', '$cant_boleto', '$boletos_block', '$fecha', '$hora', '1', '$id_usuario', '$fecha_inicio', '$fecha_fin')";
}else{
    $cadena_insertar = "UPDATE configuracion_sorteos SET sorteo='$sorteo', tiraje_boletos = '$tiraje', monto_boleto = '$cant_boleto', boletos_block = '$boletos_block', fecha = '$fecha', hora='$hora', activo='1', usuario = '$id_usuario', fecha_inicio = '$fecha_inicio', fecha_fin = '$fecha_fin'  WHERE id = '$ide'";
}


$insertar_configuracion = mysqli_query($conexion, $cadena_insertar);
echo $cadena_insertar;
?>