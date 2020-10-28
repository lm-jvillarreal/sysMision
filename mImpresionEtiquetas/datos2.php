<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');

	$fecha1      = $_POST['fecha1'];
    $fecha2      = $_POST['fecha2'];

	$consulta = mysqli_query($conexion,"
		SELECT
			(
				CONCAT( personas.nombre, ' ', personas.ap_paterno, ' ', personas.ap_materno ) 
			) AS usuario,
			count( * ) AS numFilas,
			( SELECT nombre FROM sucursales WHERE sucursales.id = solicitud_etiquetas.sucursal ) AS Suc ,
			perfil.nombre,
			solicitud_etiquetas.usuario_solicita
		FROM
			solicitud_etiquetas 
		INNER JOIN usuarios ON usuarios.id = solicitud_etiquetas.usuario_solicita
		INNER JOIN personas ON personas.id = usuarios.id_persona
		INNER JOIN perfil ON perfil.id = usuarios.id_perfil
		WHERE
			( solicitud_etiquetas.fecha BETWEEN '$fecha1' AND '$fecha2' ) 
			AND estatus = '2' AND perfil.id != '4'
		GROUP BY
			usuario 
		ORDER BY
			numFilas DESC ");
	$cuerpo ="";
	$numero = 1;
	while ($row = mysqli_fetch_array($consulta))
	{	
		$cadena_detalle = "SELECT 
		(SELECT COUNT(*) FROM detalle_solicitud WHERE cantidad = '0' AND fecha between '$fecha1' AND '$fecha2' AND usuario='$row[4]'),
		(SELECT COUNT(*) FROM detalle_solicitud WHERE cantidad > 0 AND fecha between '$fecha1' AND '$fecha2' AND usuario='$row[4]'),
		(SELECT COUNT(*) FROM detalle_solicitud WHERE fecha between '$fecha1' AND '$fecha2' AND usuario='$row[4]')
		FROM dual";
		$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
		$row_detalle=mysqli_fetch_array($consulta_detalle);
		$renglon = "
			{
			\"#\": \"$numero\",
			\"Sucursal\": \"$row[2]\",
			\"Usuario\": \"$row[0]\",
			\"Ranking\": \"$row[1]\",
			\"Correcto\": \"$row_detalle[0]\",
			\"Solicitado\": \"$row_detalle[1]\",
			\"Total\": \"$row_detalle[2]\"
			},";
		$cuerpo = $cuerpo.$renglon;
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