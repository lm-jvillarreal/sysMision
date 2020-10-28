<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];

$cadena = mysqli_query($conexion,"SELECT
						(SELECT CONCAT(nombre,' ',(SELECT nombre FROM sucursales WHERE sucursales.id = cajas.id_sucursal)) FROM cajas WHERE historial_equipos.id_caja = cajas.id),
						control_equipos.id_marca,	
						(SELECT marca FROM marcas WHERE marcas.id = control_equipos.id_marca),
						control_equipos.id_modelo,	
						(SELECT modelo FROM modelos WHERE modelos.id = control_equipos.id_modelo),
						historial_equipos.num_serie_anterior,
						historial_equipos.id,
						historial_equipos.num_reporte
					FROM historial_equipos
					INNER JOIN control_equipos ON control_equipos.id_caja = historial_equipos.id_caja
					WHERE historial_equipos.id = '$id'");

$row = mysqli_fetch_array($cadena);

$array2 = array(
	$row[0], //datos_caja
	$row[1], // id_marca
	$row[2], // nombre_marca
	$row[3], // id_modelo
	$row[4], // nombre_modelo
	$row[5], // numero_serie
	$row[6], //id_historico		
	$row[7] //num_reporte
	);

$array = json_encode($array2);
echo "$array";
?>