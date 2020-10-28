<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
  	$fecha = date("Y-m-d"); 
  	$hora = date("H:i:s"); 

	$id_promotor = $_POST['id_promotor'];

	$cadena_verificar = mysqli_query($conexion,"SELECT hora_entrada FROM registro_entrada WHERE id_promotor = '$id_promotor' AND fecha = '$fecha'");
	$existe = mysqli_num_rows($cadena_verificar);

	if($existe == 0){
		$cadena = mysqli_query($conexion,"INSERT INTO registro_entrada (id_promotor,hora_entrada,fecha,hora,activo,id_usuario)
										VALUES('$id_promotor','$hora','$fecha','$hora','1','$id_usuario')");
		echo "ok";
	}
	else{
		echo "ok";	
	}
?>