<?php
	include '../global_seguridad/verificar_sesion.php';
	$turno = $_POST['turno'];
	$id_paciente = $_POST['paciente_id'];
	$temperatura = $_POST['temperatura'];
	$peso = $_POST['peso'];
	$presion = $_POST['presion'];
	$malestar = $_POST['malestar'];
	$exploracion_fisica = $_POST['exploracion_fisica'];
	$diagnostico = $_POST['diagnostico'];

	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("H:i:s");
	$prefijo = date("Y").date("m").date("d");

	$cadena_insertar = "INSERT INTO consulta (id, turno, id_pacientes, temperatura, peso, presion, malestar, exploracion_fisica, diagnostico, fecha, hora, prefijo, acivo, usuario) VALUES (NULL, '$turno', '$id_paciente', '$temperatura','$peso','$presion','$malestar','$exploracion_fisica','$diagnostico','$fecha','$hora','$prefijo',1,'$id_usuario')";
	$insertar_consulta = mysqli_query($conexion,$cadena_insertar);

	 $actualizar_activo = mysqli_query($conexion, "UPDATE turnos SET activo= 1 WHERE consecutivo=$turno AND prefijo='$prefijo'");

	echo "ok";
?>