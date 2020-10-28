<?php
include '../global_seguridad/verificar_sesion.php';
$id_orden = $_POST['ide'];

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("H:i:s");

$cadena_iniciar = "UPDATE orden_compra SET activo='1', status='1', fecha_inicio='$fecha', hora_inicio='$hora', usuario_inicio = '$id_usuario' WHERE id = '$id_orden'";
$consulta_iniciar = mysqli_query($conexion, $cadena_iniciar);

echo $cadena_iniciar;
?>