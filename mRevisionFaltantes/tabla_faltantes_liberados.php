<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
// $folio = $_POST['folio'];
//AGUA BONAFONT 12 1.5 LTS.
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$filtro_sucursal = ($solo_sucursal == '1') ? " AND f.sucursal = '$id_sede'" : "";

$cadena_detalle = "SELECT   f.id, 
							f.cve_articulo, 
							f.descripcion_articulo, 
							f.sucursal, 
							f.fecha_revisa, 
							f.comenta_revisa, 
							u.nombre_usuario 
							FROM faltantes_pasven as f INNER JOIN usuarios as u ON f.usuario_revisa = u.id_persona
							WHERE f.estatus = '2' 
							AND DATE(f.fecha_captura) BETWEEN DATE_SUB(NOW(),INTERVAL 8 DAY) AND DATE(NOW())".$filtro_sucursal;
//echo $cadena_detalle;
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$cuerpo ="";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
	$escape_desc = mysqli_real_escape_string($conexion, $row_detalle[2]);
	$escape_coment = mysqli_real_escape_string($conexion, $row_detalle[5]);
	$link_detalle = "<center><a href='#' data-id = '$row_detalle[1]' data-toggle = 'modal' data-target = '#modal-ue' class='btn btn-danger' target='blank'>$row_detalle[1]</a></center>";
	$renglon = "
	{
		\"no\": \"$row_detalle[0]\",
		\"codigo\": \"$link_detalle\",
		\"desc\": \"$escape_desc\",
		\"comprador\": \"$row_detalle[6]\",
		\"sucursal\": \"$row_detalle[3]\",
		\"liberacion\": \"$row_detalle[4]\",
		\"comentario\": \"$escape_coment\"
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