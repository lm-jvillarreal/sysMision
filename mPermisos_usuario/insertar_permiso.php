<?php
include '../global_seguridad/verificar_sesion.php';
$usuario = $_POST['usuario'];
$modulo = $_POST['modulo'];

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

$cadena_modulos = "SELECT categoria FROM modulos WHERE id = '$modulo'";
$consulta_modulo = mysqli_query($conexion, $cadena_modulos);
$row_modulos = mysqli_fetch_array($consulta_modulo);
$categoria = $row_modulos[0];

$cadena_insertar = "INSERT INTO detalle_usuario (id_usuario, id_modulo, id_categoria, solo_sucursal, registros_propios, fecha, hora, activo, usuario) VALUES ('$usuario','$modulo','$categoria','0','0','$fecha','$hora','1','$id_usuario')";
$insertar_permiso = mysqli_query($conexion, $cadena_insertar);

echo "ok";
?>