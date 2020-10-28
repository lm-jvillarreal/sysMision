<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$hora = date("H:i:s");

$actividad = $_POST['actividad'];
$area = $_POST['areas'];
$ini_do = $_POST['ini_do'];
$fin_do = $_POST['fin_do'];
$ini_arb = $_POST['ini_arb'];
$fin_arb = $_POST['fin_arb'];
$ini_vill = $_POST['ini_vill'];
$fin_vill = $_POST['fin_vill'];
$ini_all = $_POST['ini_all'];
$fin_all = $_POST['fin_all'];
$ini_pet = $_POST['ini_pet'];
$fin_pet = $_POST['fin_pet'];

$cadena_insertar = "INSERT INTO catalogoActividades_vidvig (actividad, id_area, inicio_do, fin_do, inicio_arb, fin_arb, inicio_vill, fin_vill, inicio_all, fin_all, inicio_pet, fin_pet, fecha, hora, activo, usuario)VALUES('$actividad', '$area', '$ini_do', '$fin_do', '$ini_arb', '$fin_arb', '$ini_vill', '$fin_vill', '$ini_all', '$fin_all', '$ini_pet','$fin_pet','$fecha', '$hora', '1', '$id_usuario')";
$insertar_actividad = mysqli_query($conexion, $cadena_insertar);

echo $cadena_insertar;
?>