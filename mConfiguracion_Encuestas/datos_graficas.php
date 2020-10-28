<?php
include '../global_seguridad/verificar_sesion.php';

// header('Content-Type: application/json');

// $query = sprintf("SELECT nombre, ponderacion FROM ponderaciones ORDER BY id");

// $result = $conexion->query($query);

// $data = array();
// 	foreach ($result as $row) {
// 		$data[] = $row;
// 	}
// $result->close();

// $conexion->close();

// print json_encode($data);
echo "Resultado de Encuestas por Departamento "."<br>";

$numero = 0;
$promedio = 0;
$total_preguntas = 0;

$numero1 = 0;
$promedio1 = 0;
$total_preguntas1 = 0;

$numero2 = 0;
$promedio2 = 0;
$total_preguntas2 = 0;

$cadena_cuestionarios = mysqli_query($conexion,"SELECT folio FROM cuestionarios WHERE activo = '1' GROUP BY folio");
$cantidad_cuestionarios = mysqli_num_rows($cadena_cuestionarios);
while ($row_cuestionarios = mysqli_fetch_array($cadena_cuestionarios)) {
	$cadena_preguntas = mysqli_query($conexion,"SELECT
													re.respuesta,
													p.tipo_pregunta
												FROM
													resultados_encuestas re
												INNER JOIN preguntas p ON re.id_pregunta = p.id
												WHERE
													re.id_cuestionario = '13'
												AND re.activo = '1'");
	$cantidad_preguntas = mysqli_num_rows($cadena_preguntas);
	while ($row_respuesta = mysqli_fetch_array($cadena_preguntas)) {
		// if ($row_respuesta[1] == 2){
		// 	if ($row_respuesta[0] == 1){
		// 		$numero += 10;
		// 	}
		// 	else if ($row_respuesta[1] == 2){
		// 		$numero += 0;
		// 	}
		// 	else if ($row_respuesta[1] == 3){
		// 		$numero += 5;
		// 	}
		// }
		// else{
			$numero += $row_respuesta[0];
		//}
	}
	if ($numero == 0){
		$promedio = 0;
	}
	else{
		$promedio = $numero / $cantidad_preguntas;
	}
	$total_preguntas += $cantidad_preguntas;
	echo $numero.' - '.'Promedio:'.round($promedio,2).' - '.$row_cuestionarios[0].'<br>';
	$numero = 0;
	$promedio = 0;
	$cantidad_preguntas = 0;
}
echo "cantidad preguntas". $total_preguntas.'<br>';
echo 'Cantidad de Cuestionarios '.$cantidad_cuestionarios;
/////////////////////////////////////////////////////////////////////////////////////////////////
echo "<br>"."<br>";
echo "Resultado de Encuestas por Categoria".'<br>';

$cadena_categoria = mysqli_query($conexion,"SELECT
													id_categoria
												FROM
													preguntas
												WHERE
													activo = '1'
												GROUP BY
													id_categoria");

$cantidad_categorias = mysqli_num_rows($cadena_categoria);
while ($row_categoria = mysqli_fetch_array($cadena_categoria)) {
	$cadena_preguntas1 = mysqli_query($conexion,"SELECT
													re.respuesta,
													p.tipo_pregunta
												FROM
													resultados_encuestas re
												INNER JOIN preguntas p ON re.id_pregunta = p.id
												WHERE
													p.id_categoria = '$row_categoria[0]'
												AND re.activo = '1'");
	$cantidad_preguntas1 = mysqli_num_rows($cadena_preguntas1);
	while ($row_respuesta1 = mysqli_fetch_array($cadena_preguntas1)) {
		if ($row_respuesta1[1] == 2){
			if ($row_respuesta1[0] == 1){
				$numero1 += 10;
			}
			else if ($row_respuesta1[1] == 2){
				$numero1 += 0;
			}
			else if ($row_respuesta1[1] == 3){
				$numero1 += 5;
			}
		}
		else{
			$numero1 += $row_respuesta1[0];
		}
	}
	if ($numero1 == 0){
		$promedio1 = 0;
	}
	else{
		$total_preguntas1 += $cantidad_preguntas1;
		$promedio1 = $numero1 / $cantidad_preguntas1;
	}
	echo $numero1.' - '.'Promedio:'.round($promedio1,2).' - '.$row_categoria[0].'<br>';
	$numero1 = 0;
	$promedio1 = 0;
}
echo "cantidad preguntas". $total_preguntas1.'<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////
echo "<br>"."<br>";
echo "Resultado de Encuestas por Sucursal".'<br>';

$cadena_sucursal = mysqli_query($conexion,"SELECT
													id,nombre
												FROM
													sucursales
												WHERE
													activo = '1'");

$cantidad_sucursal = mysqli_num_rows($cadena_sucursal);
while ($row_sucursal = mysqli_fetch_array($cadena_sucursal)) {
	$cadena_preguntas2 = mysqli_query($conexion,"SELECT
													re.respuesta,
													p.tipo_pregunta
												FROM
													resultados_encuestas re
												INNER JOIN preguntas p ON re.id_pregunta = p.id
												WHERE
													re.id_sucursal = '$row_sucursal[0]'
												AND re.activo = '1'");
	$cantidad_preguntas2 = mysqli_num_rows($cadena_preguntas2);
	while ($row_respuesta2 = mysqli_fetch_array($cadena_preguntas2)) {
		// if ($row_respuesta2[1] == 2){
		// 	if ($row_respuesta2[0] == 1){
		// 		$numero2 += 10;
		// 	}
		// 	else if ($row_respuesta2[1] == 2){
		// 		$numero2 += 0;
		// 	}
		// 	else if ($row_respuesta2[1] == 3){
		// 		$numero2 += 5;
		// 	}
		// }
		// else{
			$numero2 += $row_respuesta2[0];
		//}
	}
	if ($numero2 != 0){
		$promedio2 = $numero2 / $cantidad_preguntas2;	
	}
	else{
		$promedio2 = 0;
	}
	$total_preguntas2 += $cantidad_preguntas2;
	echo $numero2.' - '.'Promedio:'.round($promedio2,2).' - '.$row_sucursal[0].'<br>';
	$numero2 = 0;
	$promedio2 = 0;
}
echo "cantidad preguntas". $total_preguntas2.'<br>';
?>