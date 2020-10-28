<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("H:i:s");

$codigo = $_POST['codigo'];
$descripcion = $_POST['descripcion'];
$sucursal = $_POST['sucursal'];
$comentario = $_POST['comentario'];

$cadena_validar = "SELECT * FROM costos_cero WHERE codigo = '$codigo'";
$consulta_validar = mysqli_query($conexion, $cadena_validar);
$row_validar = mysqli_fetch_array($consulta_validar);
$conteo = count($row_validar);

if($conteo>0){
    echo "repetido";
}elseif($conteo==0){
    $cadena_insertar = "INSERT INTO costos_cero (codigo, articulo, sucursal, fecha, hora, activo, usuario, estatus, baja, comentario)VALUES('$codigo', '$descripcion', '$sucursal', '$fecha', '$hora', '1', '$id_usuario', '1', '0', '$comentario')";
    $consulta_costo = mysqli_query($conexion, $cadena_insertar);
    echo "ok";
}
?>