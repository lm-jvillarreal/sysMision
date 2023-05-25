<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$filtro_sucursal = ($solo_sucursal == '1') ? " AND e.sucursal = '$id_sede'" : "";

$cadena_detalle = "SELECT
											e.id,
											s.nombre,
											e.nombre,
											e.fecha_solicitud,
											CONCAT( p.nombre, ' ', p.ap_paterno, ' ', p.ap_materno ),
											( SELECT nombre FROM formatos_etiquetas WHERE e.formato = formatos_etiquetas.id ) AS Formato,
											fecha_autorizacion
										FROM
											solicitud_etiquetas AS e
											INNER JOIN sucursales AS s ON e.sucursal = s.id
											INNER JOIN usuarios AS u ON e.usuario_solicita = u.id
											INNER JOIN personas AS p ON p.id = u.id_persona
											INNER JOIN detalle_solicitud AS d ON d.id_solicitud = e.id 
										WHERE
											e.estatus = '3' 
											AND e.activo = '1' 
											AND d.cantidad > 0 
											".$filtro_sucursal."
										GROUP BY
											e.id";

$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$cuerpo ="";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
	$esc_nombre = mysqli_real_escape_string($conexion, $row_detalle[2]);
	$ver = "<a href='generar_lista.php?id=$row_detalle[0]' class='btn btn-success'><i class='fa fa-file-excel-o fa-lg'></i></a>";
	$merma = "<a href='generar_lista_merma.php?id=$row_detalle[0]' class='btn btn-success'><i class='fa fa-file-excel-o fa-lg'></i></a>";
	$impreso = "<center><input type='checkbox' name='impreso' id='impreso' onchange='impreso($row_detalle[0])'></center>";
	$detalle="<a href='generar_lista_detalle.php?id=$row_detalle[0]' class='btn btn-success'><i class='fa fa-file-excel-o fa-lg'></i></a>";
	array_push($datos,array(
		'id'=>$row_detalle[0],
		'sucursal'=>$row_detalle[1],
		'nombre'=>$esc_nombre,
		'formato'=>$row_detalle[5],
		'solicitud'=>$row_detalle[3],
		'autorizacion'=>$row_detalle[6],
		'usuario'=>$row_detalle[4],
		'ver'=>$ver,
		'merma'=>$merma,
		'detalle'=>$detalle,
		'impreso'=>$impreso
	));
}
echo utf8_encode(json_encode($datos));
?>