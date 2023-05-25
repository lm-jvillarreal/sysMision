<?php
	include '../global_settings/conexion.php';
	Include '../global_settings/consulta_sqlsrvr.php';

	$id = $_POST['id'];

	$cadena_consulta = "SELECT
			i.id,
			i.nombre,
			i.categoria AS id_categoria,
			c.categoria AS categoria,
			ci.id AS id_incidencia,
			ci.incidencia AS incidencia,
			sanciones_incidencias.nombre AS sancion,
			i.comentario,
			i.decision,
			i.activo,
			i.vigilante,
			CONCAT(vidvig_vigilantes.NOMBRE,' ',vidvig_vigilantes.AP_PATERNO,' ',vidvig_vigilantes.AP_MATERNO)
		FROM
			incidencias i
		INNER JOIN catalogo_incidencias ci,
			sanciones_incidencias,
			categorias c,
			vidvig_vigilantes
		WHERE
			i.incidencia = ci.id 
		AND i.accion = sanciones_incidencias.nombre and i.categoria= c.id
		and i.vigilante=vidvig_vigilantes.id and i.id='$id'"; 

	$consulta_editar = mysqli_query($conexion, $cadena_consulta);
	$row_editar = mysqli_fetch_array($consulta_editar);

	$cadena_persona = "SELECT codigo, (cast(codigo as varchar) + ' - ' + nombre + ' ' + ap_paterno + ' ' + ap_materno) AS 'nombre' FROM empleados WHERE activo = 'S' AND codigo = '$row_editar[1]'";

	$consulta_persona = sqlsrv_query($conn, $cadena_persona);
	$row = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);

	$nombre = $row['nombre'];
	$array = array(
	$row_editar[0],//id
	$row_editar[1],//nombre mysql
	$nombre,//nombre sql
	$row_editar[2],//id_categoria
	$row_editar[3],//categoria
	$row_editar[4],//id_incidencia
	$row_editar[5],//incidencia
	$row_editar[6],//sancion
	$row_editar[7],//comentario
	$row_editar[8],//decisión
	$row_editar[9],//activo
	$row_editar[10],//idvigilante
	$row_editar[11]);//vigilante
	$array_datos = json_encode($array);
	echo $array_datos;
?>