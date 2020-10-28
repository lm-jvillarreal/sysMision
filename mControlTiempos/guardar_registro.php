<?php 
	include '../global_settings/conexion.php';
	//include '../global_settings/conexion_supsys.php';
    date_default_timezone_set('America/Monterrey');
    $fecha=date('Y-m-d');
    $hora = date('H:m:s'); 
	$pFecha = $_POST['fecha'];
	$pHoraInicio = $_POST['hora_inicio'];
	$pHoraFin = $_POST['hora_final'];
	$pComentarios = $_POST['comentarios'];
	$pUsuario = $_POST['usuario'];
	$pTipo = $_POST['tipo'];


	$call = "CALL sp_insert_tiempos('$pFecha', '$pHoraInicio', '$pHoraFin', '$pComentarios', '$pUsuario', '$pTipo', '$fecha', '$hora')";
	$exCall = mysqli_query($conexion, $call);





 ?>