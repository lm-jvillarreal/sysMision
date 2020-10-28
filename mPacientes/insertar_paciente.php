<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");


$nombre           = $_POST['nombre'];
$ap_paterno       = $_POST['ap_paterno'];
$ap_materno       = $_POST['ap_materno'];
$sexo             = $_POST['sexo'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$edad             = $_POST['edad'];
$desc_alergia     = $_POST['desc_alergia'];
$alergias         = $_POST['alergia'];

if ($alergias == "Si") {
    $desc_alergiaD = $desc_alergia;
}else{
    $desc_alergiaD = null;
}

$id_registro = $_POST['id_registro'];

$cadena_verificar = mysqli_query($conexion,"SELECT * FROM pacientes WHERE id = '$id_registro'");
$existe = mysqli_num_rows($cadena_verificar);

if($existe == 0 && $id_registro==0){
	$insertar_consulta = mysqli_query($conexion, "INSERT INTO pacientes (nombre, ap_paterno, ap_materno, sexo, fecha_nacimiento, desc_alergia, edad, alergias) VALUES ('$nombre','$ap_paterno','$ap_materno','$sexo','$fecha_nacimiento', '$desc_alergia', '$edad', '$alergias')");
	echo "ok";
}elseif($existe!=0 && $id_registro!=0){
		$cadena_actualizar = mysqli_query($conexion,"UPDATE pacientes SET nombre = '$nombre', ap_paterno = '$ap_paterno', ap_materno = '$ap_materno', sexo = '$sexo', fecha_nacimiento = '$fecha_nacimiento', desc_alergia = '$desc_alergiaD', edad = '$edad', alergias = '$alergias' WHERE id = '$id_registro'");
		echo "ok";
	}elseif($existe!=0 && $id_registro==0){
	echo "duplicado";
}
?>