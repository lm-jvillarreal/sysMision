<?php
	include '../global_seguridad/verificar_sesion.php';

	$encuesta   = $_POST['id_encuesta'];
	$id_usuario_resp = $_POST['id_usuario'];
	$cantidad_usuarios = count($id_usuario_resp);

	$title = $encuesta.' - Encuesta';
	$folio = mysqli_query($conexion,"SELECT MAX(folio) FROM agenda");
	$row = mysqli_fetch_array($folio);
	$max = $row[0] + 1;
	$fecha1 = $fecha." 12:00:00";
	$fecha_mas_un_mes = date("Y-m-d",strtotime($fecha."+ 1 month")); 
	$fecha2 = $fecha_mas_un_mes." 12:00:00";
	$color = "#5c743d";

	for ($i=0; $i < $cantidad_usuarios ; $i++) { 
		$cadena = mysqli_query($conexion,"INSERT INTO s_invitados (id_encuesta, id_usuario_resp,fecha,hora,activo,id_usuario)
			VALUES('$encuesta','$id_usuario_resp[$i]','$fecha','$hora','1','$id_usuario')");
		$cadena_agenda = mysqli_query($conexion,"INSERT INTO agenda (folio,title,start,end,id_usuario,fecha,hora,backgroundColor,borderColor)
		VALUES('$max','$title','$fecha1','$fecha2','$id_usuario_resp[$i]','$fecha','$hora','$color','$color')");
	}
	echo "ok";
?>