<?php
	include '../global_seguridad/verificar_sesion.php';

	$folio = $_POST['folio'];

	$cadena    = mysqli_query($conexion,"SELECT efectivo,efectivo1,efectivo2,complemento,cheques_serfin,cheques_locales,tarjetas_credito,total_efectivos,t_debito,t_prepago,t_accor,t_ecovale,t_efectivale,t_sivale,t_tiendapass,t_toka,total_t,b_prest_mex,b_prest_uni,b_accor,b_efectivale,b_mision_esp,b_creditos,b_tengo_despensa,b_toka,b_total,fecha,id_sucursal FROM efectivos WHERE folio = '$folio'");
	$row_datos = mysqli_fetch_array($cadena);

	$array_datos = array(
		$row_datos[0], //Efectivo
		$row_datos[1], //Efectivo1
		$row_datos[2], //Efectivo2
		$row_datos[3], //Complemento
		$row_datos[4], //Cheques_serfin
		$row_datos[5], //cheques_locales
		$row_datos[6], //tarjetas_credito
		$row_datos[7], //total_efectivos
		$row_datos[8], //t_debito
		$row_datos[9], //t_prepago
		$row_datos[10], //t_accor
		$row_datos[11], //t_ecovale
		$row_datos[12], //t_efectivale
		$row_datos[13], //t_sivale
		$row_datos[14], //t_tiendapass
		$row_datos[15], //t_toka
		$row_datos[16], //total_t
		$row_datos[17], //b_prest_mex
		$row_datos[18], //b_prest_uni
		$row_datos[19], //b_accor
		$row_datos[20], //b_efectivale
		$row_datos[21], //b_mision_esp
		$row_datos[22], //b_creditos
		$row_datos[23], //b_tengo_despensa
		$row_datos[24], //b_toka
		$row_datos[25], //b_total
		$row_datos[26], //fecha
		$row_datos[27] //id_sucursal
	);

	$array = json_encode($array_datos);
	echo $array;
?>