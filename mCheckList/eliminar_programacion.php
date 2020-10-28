<?php
  	include '../global_seguridad/verificar_sesion.php';
	$id_actividad = $_POST['id_actividad'];

	$cadena = mysqli_query($conexion,"UPDATE detalle_checklist SET programada = '0', fecha_inicio = NULL, hora_inicio = NULL, fecha_fin = NULL, hora_fin = NULL, se_repite = NULL, frecuencia = NULL, d = NULL, l = NULL, m = NULL, x=NULL, j= NULL, v=NULL, s=NULL, duracion = NULL, finaliza = NULL, dia_finaliza = NULL WHERE id = '$id_actividad'");

	echo "ok";
?>