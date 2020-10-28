<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$fecha1 = $_POST['fecha1'];
$fecha2 = $_POST['fecha2'];
$filtro = $_POST['filtro'];

$filtro_sucursal = ($solo_sucursal == '1') ? " AND et.sucursal = '$id_sede'" : "";

if($filtro == 0){
	$cadena_detalle = "SELECT et.id, 
					(SELECT nombre FROM sucursales WHERE id = et.sucursal) As 'Sucursal',
					et.nombre,
					(SELECT CONCAT(pr.nombre, ' ',pr.ap_paterno)
						FROM personas as pr INNER JOIN usuarios ON pr.id = usuarios.id_persona 
					    WHERE usuarios.id = et.usuario_solicita)  AS Solicita,
					DATE_FORMAT(et.fecha_solicitud, '%d/%m/%Y %h:%i:%s') AS 'Fecha Solicitud',
					(SELECT CONCAT(pr.nombre, ' ',pr.ap_paterno)
						FROM personas as pr INNER JOIN usuarios ON pr.id = usuarios.id_persona 
					    WHERE usuarios.id = et.usuario_imprime) AS Imprime,
					DATE_FORMAT(et.fecha_impresion, '%d/%m/%Y %h:%i:%s') AS 'Fecha impresion',
					(SELECT SEC_TO_TIME(TIMESTAMPDIFF(second, fecha_solicitud, fecha_impresion)) as TiempoTranscurrido FROM solicitud_etiquetas WHERE id = et.id) As 'Tiempo Transcurrido', et.calificacion,
					et.usuario_imprime
					FROM solicitud_etiquetas as et WHERE et.estatus='2' AND et.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_sucursal;
}else{
	$cadena_detalle = "SELECT et.id, 
					(SELECT nombre FROM sucursales WHERE id = et.sucursal) As 'Sucursal',
					et.nombre,
					(SELECT CONCAT(pr.nombre, ' ',pr.ap_paterno)
						FROM personas as pr INNER JOIN usuarios ON pr.id = usuarios.id_persona 
					    WHERE usuarios.id = et.usuario_solicita)  AS Solicita,
					DATE_FORMAT(et.fecha_solicitud,'%d/%m/%Y %h:%i:%s') AS 'Fecha Solicitud',
					(SELECT CONCAT(pr.nombre, ' ',pr.ap_paterno)
						FROM personas as pr INNER JOIN usuarios ON pr.id = usuarios.id_persona 
					    WHERE usuarios.id = et.usuario_imprime) AS Imprime,
					DATE_FORMAT(et.fecha_impresion, '%d/%m/%Y %h:%i:%s') AS 'Fecha impresion',
					(SELECT SEC_TO_TIME(TIMESTAMPDIFF(second, fecha_solicitud, fecha_impresion)) as TiempoTranscurrido FROM solicitud_etiquetas WHERE id = et.id) As 'Tiempo Transcurrido', et.calificacion,
					et.usuario_imprime
					FROM solicitud_etiquetas as et 
					INNER JOIN usuarios ON usuarios.id = et.usuario_solicita
					INNER JOIN personas ON personas.id = usuarios.id_persona
					INNER JOIN perfil ON perfil.id = usuarios.id_perfil
					WHERE et.estatus='2' AND perfil.id != '4' AND et.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_sucursal;
}

$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$cuerpo ="";
$hora1 = "00:30:00";
$hora2 = "";
$tiempo = "";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
	$calificacion = round($row_detalle[8], 2);
	$hora2 = $row_detalle[7];
	if($hora2 > $hora1){
		$tiempo = "<center><span class='badge bg-red'>$hora2</span></center>";
	}else{
		$tiempo = "<center><span>$hora2</span></center>";
	}
	if($row_detalle[9]==0){
		$imprime = "NO SE IMPRIMIÓ";
	}else{
		$imprime = $row_detalle[5];
	}
	$esc_descripcion = mysqli_real_escape_string($conexion,$row_detalle[2]);
	$renglon = "
	{
		\"id\": \"$row_detalle[0]\",
		\"sucursal\": \"$row_detalle[1]\",
		\"nombre\": \"$esc_descripcion\",
		\"solicita\": \"$row_detalle[3]\",
		\"fecha_solicitud\": \"$row_detalle[4]\",
		\"imprime\": \"$imprime\",
		\"fecha_impresion\": \"$row_detalle[6]\",
		\"tiempo_transcurre\": \"$tiempo\",
		\"calificacion\": \"$calificacion\"
	},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
//echo $cadena_detalle;
echo $tabla;
?>