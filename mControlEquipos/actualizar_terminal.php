<?php
	include '../global_seguridad/verificar_sesion.php';

	$fecha_cambio   = $_POST['fecha_cambio'];
	$d_caja         = $_POST['d_caja'];
	$marca_m        = $_POST['marca_m'];
	$modelo_m       = $_POST['modelo_m'];
	$numero_serie_m = $_POST['numero_serie_m'];
	$id_historico   = $_POST['id_historico'];

	if (strlen(stristr($numero_serie_m,'-'))>0) {
	}
	else{
	    ////////////////////Agrega giones///////////////////////
	    $numero_serie_m = wordwrap($numero_serie_m,3, "-",1);
	}

	if(strlen($numero_serie_m) == "11"){
		$cadena      = mysqli_query($conexion,"SELECT id_caja FROM historial_equipos WHERE id = '$id_historico'");
		$row         = mysqli_fetch_array($cadena);

		$cadena2 = mysqli_query($conexion,"UPDATE control_equipos SET id_marca = '$marca_m', id_modelo = '$modelo_m', numero_serie = '$numero_serie_m' WHERE id_caja = '$row[0]'");

		$cadena3 = mysqli_query($conexion,"UPDATE historial_equipos SET actualizo = '1',fecha_cambio = '$fecha_cambio',num_serie = '$numero_serie_m' WHERE id = '$id_historico'");
		echo "ok" ;
	}
	else{
		echo "1";
	}
?>