<?php
include '../global_seguridad/verificar_sesion.php';

$id_registro = $_POST['id_rg'];
$tipo_mov = $_POST['tipo_mov'];
$folio_mov = $_POST['folio_mov'];
$sucursal = $_POST['sucursal'];
$ctb_usuario = $_POST['id_usr'];
$comentarios = $_POST['comentarios'];
$nombre = $_POST['nombre_usr'];

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

if (empty($id_registro)) {
	$cadena_consulta = "INSERT INTO me_control_errores (tipo_mov, folio_mov, id_sucursal, ctb_usuario, comentarios, nombre_usuario, fecha, hora, activo, usuario)VALUES('$tipo_mov','$folio_mov','$sucursal','$ctb_usuario','$comentarios','$nombre', '$fecha', '$hora', '1', '$id_usuario')";
}else{
	$cadena_consulta = "UPDATE me_control_errores SET tipo_mov = '$tipo_mov', folio_mov='$folio_mov', id_sucursal = '$sucursal', ctb_usuario = '$ctb_usuario', comentarios = '$comentarios', nombre_usuario = '$nombre', fecha = '$fecha', hora = '$hora', activo = '1', usuario = '$id_usuario' WHERE id = '$id_registro'";
}

$cadena_insertar = $cadena_consulta;

if ($valor_soloLectura=='1') {
    echo "no";
}else{
	$consulta_insertar = mysqli_query($conexion, $cadena_insertar);
	echo "ok";
    }
?>