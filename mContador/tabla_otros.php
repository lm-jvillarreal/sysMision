<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');

	$fecha_inicio = $_POST['fecha_inicio'];
	$fecha_final  = $_POST['fecha_final'];

	$consulta = mysqli_query($conexion,"SELECT otros.folio,otros.concepto,otros.cantidad,sucursales.nombre
										FROM otros
										INNER JOIN sucursales ON otros.id_sucursal = sucursales.id
										WHERE otros.fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE)
										AND CAST('$fecha_final' AS DATE)
										AND otros.activo = '1'
										ORDER BY sucursales.nombre");
	$cuerpo ="";
	$numero = 1;
	while ($row = mysqli_fetch_array($consulta)) 
	{	
		$renglon = "
			{
			\"#\": \"$numero\",
			\"Folio\": \"$row[0]\",
			\"Concepto\": \"$row[1]\",
			\"Cantidad\": \"$ $row[2]\",
			\"Sucursal\": \"$row[3]\"
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