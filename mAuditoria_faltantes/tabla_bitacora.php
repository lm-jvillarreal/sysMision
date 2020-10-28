<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
// $folio = $_POST['folio'];
//AGUA BONAFONT 12 1.5 LTS.
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$filtro_sucursal = ($solo_sucursal == '1') ? " AND sucursal = '$id_sede'" : "";
$cadena_detalle = "SELECT f.id, 
										f.cve_articulo, 
										f.descripcion_articulo,
										f.estatus,
										s.nombre,
										f.sucursal,
										u.nombre_usuario,
										f.comentario_auditor,
										DATE_FORMAT(f.fecha_audita, '%d/%m/%Y')
									FROM faltantes_pasven as f INNER JOIN sucursales as s ON f.sucursal = s.id
									INNER JOIN usuarios as u ON f.usuario_auditor = u.id
									WHERE f.estatus = '8'";
//echo $cadena_detalle;
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$cuerpo ="";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
	$escape_desc = mysqli_real_escape_string($conexion, $row_detalle[2]);

    $estatus =  "<center><span class='label label-success'>Auditado</span></center>";
	$renglon = "
	{
		\"no\": \"$row_detalle[0]\",
		\"codigo\": \"$row_detalle[1]\",
		\"desc\": \"$escape_desc\",
		\"sucursal\": \"$row_detalle[4]\",
    \"auditor\": \"$row_detalle[6]\",
    \"comentario\": \"$row_detalle[7]\",
		\"fecha_audita\": \"$row_detalle[8]\"
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