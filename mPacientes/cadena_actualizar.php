<?php
include '../global_settings/conexion.php';

	$id_paciente = $_POST['paciente_id'];
	$nombre = $_POST['nombre'];
	$ap_paterno = $_POST['ap_paterno'];
	$ap_materno = $_POST['ap_materno'];
	$sexo = $_POST['sexo'];
	$fecha_nacimiento = $_POST['fecha_nacimiento'];
	$edad = $_POST['edad'];
	$desc_alergia = $_POST['desc_alergia'];
	$alergias = $_POST['alergia'];

	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d");
	$hora=date ("h:i:s");

	if ($alergias == "Si") {
	    $desc_alergiaD = $desc_alergia;
	}else{
	    $desc_alergiaD = null;
	}

	$cadena_actualizar = "UPDATE pacientes SET nombre = '$nombre', ap_paterno = '$ap_paterno', ap_materno = '$ap_materno', sexo = '$sexo', fecha_nacimiento = '$fecha_nacimiento', desc_alergia = '$desc_alergiaD', edad = '$edad', alergias = '$alergias' WHERE id = '$id_paciente'";

	$insertar_actualizar= mysqli_query($conexion, $cadena_actualizar);
	echo "ok";
?>