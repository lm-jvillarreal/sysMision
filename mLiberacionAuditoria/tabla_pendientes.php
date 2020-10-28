<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$filtro_sucursal = ($solo_sucursal == '1') ? " AND e.sucursal = '$id_sede'" : "";

$cadena_detalle = "SELECT e.id, s.nombre, e.nombre, DATE_FORMAT(e.finaliza_solicitud,'%d/%m/%Y %H:%i:%s'), CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno),
				  (SELECT nombre FROM formatos_etiquetas WHERE e.formato = formatos_etiquetas.id) AS Formato,
				  e.tipo,
					(SELECT SEC_TO_TIME(TIMESTAMPDIFF(second, fecha_solicitud, finaliza_solicitud)) as TiempoTranscurrido FROM solicitud_etiquetas WHERE id = e.id) As 'Tiempo Transcurrido'
					FROM solicitud_etiquetas AS e INNER JOIN  sucursales AS s ON e.sucursal = s.id
					INNER JOIN usuarios AS u ON e.usuario_solicita = u.id 
					INNER JOIN personas AS p ON p.id = u.id_persona
					WHERE e.estatus='1' AND e.activo = '1'".$filtro_sucursal;

$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$cuerpo ="";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {

    $cadena_cantidad = "SELECT COUNT(id) FROM detalle_solicitud WHERE id_solicitud = '$row_detalle[0]'";
    $consulta_cantidad = mysqli_query($conexion, $cadena_cantidad);
    $row_cantidad = mysqli_fetch_array($consulta_cantidad);

	
	$eliminar = "<button id='eliminar' name='eliminar' onclick='eliminar($row_detalle[0])' class='btn btn-danger btn-sm'><i class='fa fa-trash-o fa-lg'></i></button></center>";
	if($row_detalle[6]=='0'){
		$tipo = "<center><span class='label label-warning'>Auditoría</span></center>";
		$autorizar = "<button id='autorizar' name='autorizar' onclick='autorizar($row_detalle[0])' class='btn btn-success btn-sm'><i class='fa fa-check fa-lg'></i></button>";
	}else{
		$tipo = "<center><span class='label label-danger'>Listado</span></center>";
		$autorizar = "";
	}
	$ver = "<center><a href='#' data-folio = '$row_detalle[0]' data-toggle = 'modal' data-target = '#modal-codigos' class='btn btn-primary btn-sm' target='blank'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a>";
	$nombre = mysqli_real_escape_string($conexion,$row_detalle[2]);
	$renglon = "
	{
		\"id\": \"$row_detalle[0]\",
		\"sucursal\": \"$row_detalle[1]\",
		\"nombre\": \"$nombre\",
		\"formato\": \"$row_detalle[5]\",
		\"tipo\": \"$tipo\",
		\"fecha\": \"$row_detalle[3]\",
		\"usuario\": \"$row_detalle[4]\",
		\"tiempo\": \"$row_detalle[7]\",
		\"cantidad\": \"$row_cantidad[0]\",
		\"autorizar\": \"$ver $autorizar $eliminar\"
	},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
//echo $cadena_cartas;
echo $tabla;
?>