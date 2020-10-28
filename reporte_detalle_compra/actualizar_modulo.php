<?php
session_name("utl_byp");
session_start();
include'../global_settings/conexion.php';
if ($_SESSION["utl_byp_autenticado"] != "SI") {
//Redireccionar a Login
echo "<script>window.location = '../mLogin/index.php';</script>";

  }else{
  	//Variables de Sesión
    $id_usuario = $_SESSION["utl_byp_id_usuario"];
    $id_persona = $_SESSION["utl_byp_id_persona"];
    $perfil_usuario = $_SESSION["utl_byp_perfil"];
    $nombre_persona = $_SESSION["utl_byp_persona"];

$id_modulo = $_POST['id_modulo'];
$nombre_modulo = $_POST['nombre_modulo'];
$nombre_carpeta = $_POST['nombre_carpeta'];
$descripcion_modulo = $_POST['descripcion_modulo'];

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$cadena_actualizar = "UPDATE modulos SET nombre='$nombre_modulo', nombre_carpeta='$nombre_carpeta', descripcion = '$descripcion_modulo', fecha = '$fecha', hora = '$hora', activo = '1', usuario = '$id_usuario' WHERE id = '$id_modulo'";

$actualizar_modulo = mysqli_query($conexion, $cadena_actualizar);

echo "<script>window.location = '../mModulos/index.php';</script>";
//echo $cadena_actualizar;
}
?>