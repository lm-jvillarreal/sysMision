<?php
	include '../global_seguridad/verificar_sesion.php';
	$invitados = $_POST['invitados'];
	$folio = $_POST['folio'];
	$cantidad  = count($invitados);

	for ($i=0; $i < $cantidad ; $i++) { 
		$cadena_verificar = mysqli_query($conexion,"SELECT id_usuario,title,start,end,backgroundColor,borderColor FROM agenda WHERE folio = '$folio'");
		$row_verificar = mysqli_fetch_array($cadena_verificar);
		if ($row_verificar[0] == $invitados[$i]){}
		else{
			$cadena = mysqli_query($conexion,"INSERT INTO agenda (folio,title,start,end,backgroundColor,borderColor,fecha,hora,id_usuario)
					VALUES ('$folio','$row_verificar[1]','$row_verificar[2]','$row_verificar[3]','$row_verificar[4]','$row_verificar[5]','$fecha','$hora','$invitados[$i]')");
		}
	}
	echo "ok";
?>