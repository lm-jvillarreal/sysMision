<?php
	include '../global_settings/conexion.php';

	if(isset($_POST['sucursal'])){
		$sucursal = $_POST['sucursal'];
	}
	if(isset($_POST['categoria'])){
		$categoria = $_POST['categoria'];
	}
	if(isset($_POST['departamento'])){
		$departamento = $_POST['departamento'];
	}
	if (isset($_POST['agrupacion'])){
		$agrupacion = $_POST['agrupacion'];
	}
	if (isset($_POST['fecha_inicio'])){
		$fecha_inicio = $_POST['fecha_inicio'];
	}
	if (isset($_POST['fecha_fin'])){
		$fecha_fin = $_POST['fecha_fin'];
	}

	if (empty($agrupacion) && empty($sucursal) && empty($categoria) && empty($departamento) && empty($pregunta)){
		$cadena   = "SELECT id,nombre FROM agrupaciones WHERE activo = '1'";
		$consulta = mysqli_query($conexion,$cadena);
		$cantidad = mysqli_num_rows($consulta);

		$numero   = 0;
		$promedio = 0;
		$json     = [];

		while ($row = mysqli_fetch_array($consulta)) {
			$cadena2 = "SELECT re.respuesta
			             FROM resultados_encuestas re
			             LEFT JOIN preguntas p ON p.id = re.id_pregunta
			             LEFT JOIN departamentos d ON d.id = p.id_departamento
			             LEFT JOIN agrupaciones a ON a.id = d.id_agrupacion
			             WHERE re.activo = '1'
			             AND re.id_usuario = '2'
			             AND a.id = '$row[0]'
			             AND re.fecha BETWEEN CAST('$fecha_inicio' AS DATE)
						 AND CAST('$fecha_fin' AS DATE)";
			$consulta2 = mysqli_query($conexion,$cadena2);
			$cantidad2 = mysqli_num_rows($consulta2);
			while ($row2 = mysqli_fetch_array($consulta2)) {
			  $numero += $row2[0];
			}
			if($numero == 0){
			  $promedio = 0;
			}
			else{
			  $promedio = $numero / $cantidad2;
			}

			$json[]   = [(string)$row[1], $promedio];
			$promedio = 0;
			$numero   = 0;
		}
		echo json_encode($json);
	}

    if (!empty($agrupacion) && empty($sucursal) && empty($categoria) && empty($departamento) && empty($pregunta)){
    	$cadena = "SELECT id,nombre FROM sucursales WHERE activo = '1'";
	    $consulta = mysqli_query($conexion,$cadena);
		$cantidad = mysqli_num_rows($consulta);

		$numero   = 0;
		$promedio = 0;
		$json     = [];

		while ($row = mysqli_fetch_array($consulta)) {
			$cadena2 = "SELECT re.respuesta
			             FROM resultados_encuestas re
			             LEFT JOIN preguntas p ON p.id = re.id_pregunta
			             LEFT JOIN departamentos d ON d.id = p.id_departamento
			             LEFT JOIN agrupaciones a ON a.id = d.id_agrupacion
			             WHERE re.activo = '1'
			             AND re.id_usuario = '2'
			             AND a.id = '$agrupacion'
			             AND re.id_sucursal = '$row[0]'
			             AND re.fecha BETWEEN CAST('$fecha_inicio' AS DATE)
						 AND CAST('$fecha_fin' AS DATE)";
			$consulta2 = mysqli_query($conexion,$cadena2);
			$cantidad2 = mysqli_num_rows($consulta2);
			while ($row2 = mysqli_fetch_array($consulta2)) {
			  $numero += $row2[0];
			}
			if($numero == 0){
			  $promedio = 0;
			}
			else{
			  $promedio = $numero / $cantidad2;
			}

			$json[] = [(string)$row[1], $promedio];
			$promedio = 0;
			$numero = 0;
		}
		echo json_encode($json);
	}
	if (!empty($agrupacion) && !empty($sucursal) && empty($categoria) && empty($departamento) && empty($pregunta)){
		$cadena = "SELECT id_categoria,CASE id_categoria 
		              WHEN '1' THEN
		              'Frescura y Calidad' 
		              WHEN '2' THEN
		              'Orden y Acomodo de Mercancia'
		              WHEN '3' THEN
		              'Atencion y Servicio al Cliente'
		              WHEN '4' THEN
		              'Limpieza en Tiendas'
		            END AS id_categoria FROM preguntas WHERE activo = '1' GROUP BY id_categoria";
	    $consulta = mysqli_query($conexion,$cadena);
		$cantidad = mysqli_num_rows($consulta);

		$numero   = 0;
		$promedio = 0;
		$json     = [];

		while ($row = mysqli_fetch_array($consulta)) {
			$cadena2 = "SELECT re.respuesta
			             FROM resultados_encuestas re
			             LEFT JOIN preguntas p ON p.id = re.id_pregunta
			             LEFT JOIN departamentos d ON d.id = p.id_departamento
			             LEFT JOIN agrupaciones a ON a.id = d.id_agrupacion
			             WHERE re.activo = '1'
			             AND re.id_usuario = '2'
			             AND a.id = '$agrupacion'
			             AND re.id_sucursal = '$sucursal'
			             AND p.id_categoria = '$row[0]'
			             AND re.fecha BETWEEN CAST('$fecha_inicio' AS DATE)
						 AND CAST('$fecha_fin' AS DATE)";
			$consulta2 = mysqli_query($conexion,$cadena2);
			$cantidad2 = mysqli_num_rows($consulta2);
			while ($row2 = mysqli_fetch_array($consulta2)) {
			  $numero += $row2[0];
			}
			if($numero == 0){
			  $promedio = 0;
			}
			else{
			  $promedio = $numero / $cantidad2;
			}

			$json[] = [(string)$row[1], $promedio];
			$promedio = 0;
			$numero = 0;
		}
		echo json_encode($json);
	}
	if (!empty($agrupacion) && !empty($sucursal) && !empty($categoria) && empty($departamento) && empty($pregunta)){
		$cadena = "SELECT id,nombre FROM departamentos WHERE activo = '1'";
	    $consulta = mysqli_query($conexion,$cadena);
		$cantidad = mysqli_num_rows($consulta);

		$numero   = 0;
		$promedio = 0;
		$json     = [];

		while ($row = mysqli_fetch_array($consulta)) {
			$cadena2 = "SELECT re.respuesta
			             FROM resultados_encuestas re
			             LEFT JOIN preguntas p ON p.id = re.id_pregunta
			             LEFT JOIN departamentos d ON d.id = p.id_departamento
			             LEFT JOIN agrupaciones a ON a.id = d.id_agrupacion
			             WHERE re.activo = '1'
			             AND re.id_usuario = '2'
			             AND a.id = '$agrupacion'
			             AND re.id_sucursal = '$sucursal'
			             AND p.id_categoria = '$categoria'
			             AND d.id = '$row[0]'
			             AND re.fecha BETWEEN CAST('$fecha_inicio' AS DATE)
						 AND CAST('$fecha_fin' AS DATE)";
			$consulta2 = mysqli_query($conexion,$cadena2);
			$cantidad2 = mysqli_num_rows($consulta2);
			while ($row2 = mysqli_fetch_array($consulta2)) {
			  $numero += $row2[0];
			}
			if($numero == 0){
			  $promedio = 0;
			}
			else{
			  $promedio = $numero / $cantidad2;
			}

			$json[] = [(string)$row[1], $promedio];
			$promedio = 0;
			$numero = 0;
		}
		echo json_encode($json);
	}
	if (!empty($agrupacion) && !empty($sucursal) && !empty($categoria) && !empty($departamento) && empty($pregunta)){
		$cadena = "SELECT id,pregunta FROM preguntas WHERE activo = '1' AND id_departamento = '$departamento'";
	    $consulta = mysqli_query($conexion,$cadena);
		$cantidad = mysqli_num_rows($consulta);

		$numero   = 0;
		$promedio = 0;
		$json     = [];

		while ($row = mysqli_fetch_array($consulta)) {
			$cadena2 = "SELECT re.respuesta
			             FROM resultados_encuestas re
			             LEFT JOIN preguntas p ON p.id = re.id_pregunta
			             LEFT JOIN departamentos d ON d.id = p.id_departamento
			             LEFT JOIN agrupaciones a ON a.id = d.id_agrupacion
			             WHERE re.activo = '1'
			             AND re.id_usuario = '2'
			             AND a.id = '$agrupacion'
			             AND re.id_sucursal = '$sucursal'
			             AND d.id = '$departamento'
			             AND p.id = '$row[0]'
			             AND re.fecha BETWEEN CAST('$fecha_inicio' AS DATE)
						 AND CAST('$fecha_fin' AS DATE)";
			             // echo $cadena2;
			$consulta2 = mysqli_query($conexion,$cadena2);
			$cantidad2 = mysqli_num_rows($consulta2);
			while ($row2 = mysqli_fetch_array($consulta2)) {
			  $numero += $row2[0];
			}
			if($numero == 0){
			  $promedio = 0;
			}
			else{
			  $promedio = $numero / $cantidad2;
			}

			$json[] = [(string)$row[1], $promedio];
			$promedio = 0;
			$numero = 0;
		}
		echo json_encode($json);
	}
?>