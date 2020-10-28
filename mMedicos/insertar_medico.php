<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$id_persona    = $_POST['id_persona'];
$cedula        = $_POST['cedula'];
$instituciones = $_POST['instituciones'];
$instituciones = strtoupper($instituciones);
$instituciones = strtr($instituciones,"áéíóú","ÁÉÍÓÚ");
$especialidad  = $_POST['especialidad'];
$especialidad  = strtoupper($especialidad);
$especialidad  = strtr($especialidad,"áéíóú","ÁÉÍÓÚ");

$id_registro = $_POST['id_registro'];

$cadena_verificar = mysqli_query($conexion,"SELECT id FROM medicos WHERE id_persona = '$id_persona'");
$existe = mysqli_num_rows($cadena_verificar);

if($existe == 0){
		$cadena_insertar = "INSERT INTO medicos (id_persona, cedula, instituciones, especialidad, fecha, hora, activo) VALUES ('$id_persona','$cedula','$instituciones','$especialidad', '$fecha', '$hora','1')";
		$insertar_consulta = mysqli_query($conexion, $cadena_insertar);
	echo "ok";
}else{
	echo "duplicado";
}
 ?>