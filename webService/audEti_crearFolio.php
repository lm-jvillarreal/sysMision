<?php
include '../global_settings/conexion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");
$fecha_solicitud = date("Y-m-d H:i:s");

$nombre = $_POST['nombreAuditoria'];
$formato = $_POST['formatoEtiquetas'];
$id_usuario=$_POST['id_persona'];

$cadenaSucursal="SELECT (SELECT id_sede FROM personas WHERE id=usuarios.id_persona) FROM usuarios where id='$id_usuario'";
$consultaSucursal=mysqli_query($conexion,$cadenaSucursal);
$rowSucursal=mysqli_fetch_array($consultaSucursal);
$id_sede=$rowSucursal[0];

$cadena_insertar = "INSERT INTO solicitud_etiquetas (nombre, formato, sucursal, estatus, tipo, fecha_solicitud, fecha, hora, activo, usuario_solicita)VALUES('$nombre', '$formato', '$id_sede', '0', '0', '$fecha_solicitud', '$fecha', '$hora', '0', '$id_usuario')";
$insertar_solicitud = mysqli_query($conexion, $cadena_insertar);

$cadena_maximo = "SELECT MAX(id), (SELECT nombre FROM solicitud_etiquetas WHERE id=MAX(S.id)) FROM solicitud_etiquetas AS S ORDER BY ID DESC";
$consulta_maximo = mysqli_query($conexion, $cadena_maximo);
$row_maximo = mysqli_fetch_array($consulta_maximo);

$auditoria=array();
array_push($auditoria,array(
  'id_auditoria'=>$row_maximo[0],
  'nombre_auditoria'=>$row_maximo[1]
));
echo utf8_encode(json_encode($auditoria));
?>