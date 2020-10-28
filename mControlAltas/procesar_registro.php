<?php
	include '../global_seguridad/verificar_sesion.php';

	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id_registro = $_POST['id_registro'];
	
	$cadena = mysqli_query($conexion,"UPDATE altas_productos SET fecha_proceso = '$fecha', hora_proceso = '$hora',usuario_proceso = '$id_usuario', estatus = '1' WHERE id = '$id_registro'");


	/////////////////////// AGENDA /////////////////////////
	$cadena2 = mysqli_query($conexion,"SELECT id_comprador,id_sucursal FROM altas_productos WHERE id = '$id_registro'");
	$row2    = mysqli_fetch_array($cadena2);
	$cadena3 = mysqli_query($conexion,"SELECT id FROM usuarios WHERE id_persona = '$row2[0]'");
	$row3    = mysqli_fetch_array($cadena3);
	$folio        = 0;
	$cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM agenda");
	$row_folio    = mysqli_fetch_array($cadena_folio);
	$folio        = $row_folio[0] + 1;

	$hex = '#';
	if ($cant != 0){
		$hex = $row[0];
	}
	else{
		foreach(array('r', 'g', 'b') as $color){
			//Random number between 0 and 255.
			$val = mt_rand(0, 255);
			//Convert the random number into a Hex value.
			$dechex = dechex($val);
			//Pad with a 0 if length is less than 2.
			if(strlen($dechex) < 2){
			    $dechex = "0" . $dechex;
			}
			//Concatenate
			$hex .= $dechex;
		}
	}
	$sucursal = "";

	if($row2[1] == "1"){
		$sucursal = "D.O";		
	}else if($row2[1] == "2"){
		$sucursal = "ARB";		
	}else if($row2[1] == "3"){
		$sucursal = "VILL";		
	}else if($row2[1] == "4"){
		$sucursal = "ALL";		
	}

	$title        = $id_registro." Alta Producto - ".$sucursal;

	$fecha_nueva = date($fecha);
	$nuevafecha  = strtotime ( '+1 day' , strtotime ( $fecha_nueva ) ) ;
	$nuevafecha  = date ( 'Y-m-d' , $nuevafecha );

	$fecha1 = $fecha.' 12:00:00';
	$fecha2 = $nuevafecha.' 12:00:00';

	$cadena_agenda = mysqli_query($conexion,"INSERT INTO agenda (folio,title,start,end,id_usuario,fecha,hora,backgroundColor,borderColor)
			VALUES ('$folio','$title','$fecha1','$fecha2','$row3[0]','$fecha','$hora','$hex','$hex')");
	$cadena_agenda2 = mysqli_query($conexion,"INSERT INTO agenda (folio,title,start,end,id_usuario,fecha,hora,backgroundColor,borderColor)
			VALUES ('$folio','$title','$fecha1','$fecha2','2','$fecha','$hora','$hex','$hex')");
?>