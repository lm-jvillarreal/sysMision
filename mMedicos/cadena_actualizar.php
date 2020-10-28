<?php 
include '../global_seguridad/verificar_sesion.php';

$id_medico = $_POST['medico_id'];
$id_persona = $_POST['id_persona'];
$cedula = $_POST['cedula'];
$instituciones = $_POST['instituciones'];
$instituciones = strtoupper($instituciones);
$instituciones = strtr($instituciones,"áéíóú","ÁÉÍÓÚ");
$especialidad = $_POST['especialidad'];
$especialidad = strtoupper($especialidad);
$especialidad = strtr($especialidad,"áéíóú","ÁÉÍÓÚ");

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$insertar_actualizar= mysqli_query($conexion, "UPDATE medicos SET id_persona = '$id_persona', cedula = '$cedula', instituciones = '$instituciones', especialidad = '$especialidad' WHERE id = '$id_medico'");
echo "ok";
?>