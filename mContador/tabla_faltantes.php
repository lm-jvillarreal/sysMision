<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');

	$fecha_inicio = $_POST['fecha_inicio'];
	$fecha_final  = $_POST['fecha_final'];

	$cadena = "SELECT
					tabla.moneda,
					tabla.ODiaz,
					tabla.Arboledas,
					tabla.Villegas,
					tabla.Allende
				FROM
					(
						SELECT
							moneda,id,
							(
								SELECT
									SUM(faltante)
								FROM
									faltantes f
								WHERE
									id_sucursal = '1'
								AND f.moneda = faltantes.moneda
								AND f.fecha BETWEEN CAST('$fecha_inicio' AS DATE)
								AND CAST('$fecha_final' AS DATE)
							) AS ODiaz,
							(
								SELECT
									SUM(faltante)
								FROM
									faltantes f
								WHERE
									id_sucursal = '2'
								AND f.moneda = faltantes.moneda
								AND f.fecha BETWEEN CAST('$fecha_inicio' AS DATE)
								AND CAST('$fecha_final' AS DATE)
							) AS Arboledas,
							(
								SELECT
									SUM(faltante)
								FROM
									faltantes f
								WHERE
									id_sucursal = '3'
								AND f.moneda = faltantes.moneda
								AND f.fecha BETWEEN CAST('$fecha_inicio' AS DATE)
								AND CAST('$fecha_final' AS DATE)
							) AS Villegas,
							(
								SELECT
									SUM(faltante)
								FROM
									faltantes f
								WHERE
									id_sucursal = '4'
								AND f.moneda = faltantes.moneda
								AND f.fecha BETWEEN CAST('$fecha_inicio' AS DATE)
								AND CAST('$fecha_final ' AS DATE)
							) AS Allende
						FROM
							faltantes
						GROUP BY 
							faltantes.moneda
						ORDER BY
							faltantes.id
					) AS tabla";

	$consulta = mysqli_query($conexion, $cadena);

	$cuerpo = "";
	$numero = 1;

	while ($row = mysqli_fetch_array($consulta)) 
	{
		if ($row[1] == ""){ $row[1] = 0;}
		if ($row[2] == ""){ $row[2] = 0;}
		if ($row[3] == ""){ $row[3] = 0;}
		if ($row[4] == ""){ $row[4] = 0;}
		$suma = $row[1]+$row[2]+$row[3]+$row[4];
		$total = $suma * $row[0];
		$renglon = "
			{
			\"#\": \"$numero\",
			\"Monedas\": \"$ $row[0]\",
			\"FaltDO\": \"$row[1]\",
			\"FaltArboledas\": \"$row[2]\",
			\"FaltVillegas\": \"$row[3]\",
			\"FaltAllende\": \"$row[4]\",
			\"FaltTotal\": \" $suma\",
			\"Valor\": \"$ $total\"
			},";
		$cuerpo = $cuerpo.$renglon;
		$suma="";
		$numero ++;
	}
	$cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
	$tabla = "
	["
	.$cuerpo2.
	"]
	";
	echo $tabla;
 ?>