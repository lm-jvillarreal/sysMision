<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');

	$fecha_inicio = $_POST['fecha_inicio'];
	$fecha_final  = $_POST['fecha_final'];
	
	$bd = array(0 => 'efectivo',
				1 => 'efectivo1',
				2 => 'efectivo2',
				3 => 'complemento',
				4 => 'cheques_serfin',
				5 => 'cheques_locales',
				6 => 'tarjetas_credito',
				7 => 't_debito',
				8 => 't_prepago', 
				9 => 't_accor',
				10 => 't_ecovale',
				11 => 't_efectivale',
				12 => 't_sivale',
				13 => 't_tiendapass',
				14 => 'total_t',
				15 => 'b_prest_mex',
				16 => 'b_prest_uni',
				17 => 'b_accor',
				18 => 'b_efectivale',
				19 => 'b_mision_esp',
				20 => 'b_creditos',
				21 => 'b_total');

	$nombre = array(0 => 'Efectivo',
					1 => 'Efectivo1',
					2 => 'Efectivo2',
					3 => 'Complemento',
					4 => 'Cheques Serfin',
					5 => 'Cheques Locales',
					6 => 'Tarjetas Credito',
					7 => 'T.Debito',
					8 => 'T.Prepago',
					9 => 'T.ACCOR',
					10 => 'T.Ecovale',
					11 => 'T.Efectivale',
					12 => 'T.Si Vale',
					13 => 'T. Tienda PASS',
					14 => 'Total Tarjetas',
					15 => 'B. Prestaciones Mex.',
					16 => 'B. Prestaciones Univ.',
					17 => 'B. ACCOR',
					18 => 'B. Efectivale',
					19 => 'B. Mision Especial',
					20 => 'B. Creditos',
					21 => 'Bonos Total');
	$cuerpo = "";
	$numero = 0;
	for ($i=0; $i < 20; $i++) {
		$numero = $i + 1;
		$cadena = "SELECT
					*
				FROM
					(
						SELECT
							(
								SELECT
									SUM($bd[$i])
								FROM
									efectivos
								WHERE
									id_sucursal = '1'
								AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE)
								AND CAST('$fecha_final' AS DATE)
								AND activo = '1'
							) AS Ordaz,
							(
								SELECT
									SUM($bd[$i])
								FROM
									efectivos
								WHERE
									id_sucursal = '2'
								AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE)
								AND CAST('$fecha_final' AS DATE)
								AND activo = '1'
							) AS Arboledas,
							(
								SELECT
									SUM($bd[$i])
								FROM
									efectivos
								WHERE
									id_sucursal = '3'
								AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE)
								AND CAST('$fecha_final' AS DATE)
								AND activo = '1'
							) AS Villegas,
							(
								SELECT
									SUM($bd[$i])
								FROM
									efectivos
								WHERE
									id_sucursal = '4'
								AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE)
								AND CAST('$fecha_final' AS DATE)
								AND activo = '1'
							) AS Allende
						FROM
							efectivos
					) AS tabla";

		$consulta = mysqli_query($conexion, $cadena);
		$row = mysqli_fetch_array($consulta);

		if ($row[0] == ""){ $row[0] = "0.00";}
		if ($row[1] == ""){ $row[1] = "0.00";}
		if ($row[2] == ""){ $row[2] = "0.00";}
		if ($row[3] == ""){ $row[3] = "0.00";}
		
		$suma = $row[0]+$row[1]+$row[2]+$row[3];
		
		$renglon = "
			{
			\"#\": \"$numero\",
			\"Efectivos\": \"$nombre[$i]\",
			\"DO\": \"$ $row[0]\",
			\"Arboledas\": \"$ $row[1]\",
			\"Villegas\": \"$ $row[2]\",
			\"Allende\": \"$ $row[3]\",
			\"Total\": \"$ $suma\"
			},";

		$cuerpo = $cuerpo.$renglon;

	}
	
	$cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
	$tabla = "
	["
	.$cuerpo2.
	"]
	";
	echo $tabla;
 ?>