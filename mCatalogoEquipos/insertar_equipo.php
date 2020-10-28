<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$equipo = $_POST['equipo'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$especificacion = $_POST['especificacion'];
$no_serie = $_POST['no_serie'];
$prioridad = $_POST['prioridad'];
$grupo = $_POST['grupo'];
$sucursal = $_POST['sucursal'];
$area = $_POST['area'];
$tipo_equipo = $_POST['tipo_equipo'];
$proveedor = $_POST['proveedor'];
$fecha_alta = date("Y-m-d", strtotime($_POST['fecha_alta']));

$cadena_abrevia = "SELECT abreviatura FROM mtto_grupo WHERE id = '$grupo'";
$consulta_abrevia = mysqli_query($conexion, $cadena_abrevia);
$row_abrevia = mysqli_fetch_array($consulta_abrevia);
$abrevia = $row_abrevia[0];
$suc = "0".$sucursal;
$cod_int = $abrevia.$suc;

$cadena_consecutivo = "SELECT COUNT(id) FROM mtto_catalogo_equipos WHERE codigo_interno = '$cod_int'";
$consulta_consecutivo = mysqli_query($conexion, $cadena_consecutivo);
$row_consecutivo = mysqli_fetch_array($consulta_consecutivo);
$consec = $row_consecutivo[0]+1;
$consecutivo = "";
if ($consec < 10) {
	$consecutivo = "00".$consec;
} elseif ($consec >= 10 AND $consec <= 99) {
	$consecutivo = "0".$consec;
} elseif ($consec >= 100) {
	$consecutivo = $consec;
}

$cadena_insertar = "INSERT INTO mtto_catalogo_equipos (equipo, marca, modelo, no_serie, codigo_interno, consecutivo, prioridad, id_grupo, sucursal, id_area, id_tipoEquipo, clave_proveedor, fecha_alta, fecha, hora, activo, usuario)VALUES('$equipo', '$marca', '$modelo', '$no_serie', '$cod_int', '$consecutivo', '$prioridad', '$grupo', '$sucursal', '$area', '$tipo_equipo', '$proveedor', '$fecha_alta', '$fecha','$hora','1','$id_usuario')";

$inserta_equipo = mysqli_query($conexion, $cadena_insertar);

echo "ok";
?>