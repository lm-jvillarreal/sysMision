<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$fecha_inicial=$_POST['fecha_inicial'];
$fecha_final=$_POST['fecha_final'];

$filtro_sucursal = ($solo_sucursal == '1') ? " AND e.sucursal = '$id_sede'" : "";

$cadena_detalle = "SELECT e.id, s.nombre, e.nombre, e.fecha, CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno),(SELECT nombre FROM formatos_etiquetas WHERE e.formato = formatos_etiquetas.id) AS Formato
					FROM solicitud_etiquetas AS e INNER JOIN  sucursales AS s ON e.sucursal = s.id
					INNER JOIN usuarios AS u ON e.usuario_solicita = u.id 
					INNER JOIN personas AS p ON p.id = u.id_persona 
					WHERE e.estatus='2' AND e.activo = '1' AND (e.fecha>='$fecha_inicial' AND e.fecha<='$fecha_final')".$filtro_sucursal;

					//echo $cadena_detalle;

$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$cuerpo ="";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
	$esc_descripcion= mysqli_real_escape_string($conexion, $row_detalle[2]);
	$ver = "<a href='generar_lista.php?id=$row_detalle[0]' class='btn btn-success'><i class='fa fa-file-excel-o fa-lg'></i></a>";
	$eliminar = "<center><button id='btn-eliminar' class='btn btn-danger' onclick='eliminar($row_detalle[0])'><i class='fa fa-trash-o fa-lg'></i></button></center>";
	$cancelar = "<center><input type='checkbox' name='cancelar' id='cancelar' onchange='cancelar_impreso($row_detalle[0])'></center>";

	array_push($datos,array(
		'id'=>$row_detalle[0],
		'sucursal'=>$row_detalle[1],
		'nombre'=>$esc_descripcion,
		'formato'=>$row_detalle[5],
		'fecha'=>$row_detalle[3],
		'usuario'=>$row_detalle[4],
		'ver'=>$ver,
		'eliminar'=>$eliminar,
		'cancelar'=>$cancelar
	));

}
//echo $cadena_cartas;
echo utf8_encode(json_encode($datos));
?>