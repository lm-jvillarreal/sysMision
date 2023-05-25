<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$solo_suc = ($solo_sucursal == '1') ? " AND d.id_sucursal='$id_sede'" : "";
$cadena_cartas = "SELECT
				s.nombre,
				d.folio,
				d.numero_proveedor,
				DATE_FORMAT(d.fecha, '%d/%m/%Y'),
				d.tipo,
				d.`status`,
				p.proveedor,
				d.id,
				u.nombre_usuario,
				d.id_sucursal
			FROM
				devoluciones d
			INNER JOIN sucursales s ON s.id = d.id_sucursal
			INNER JOIN proveedores p ON p.numero_proveedor = d.numero_proveedor
			INNER JOIN usuarios u ON d.usuario_autoriza = u.id 
			WHERE d.`status` = '0'".$solo_suc;

$consulta_cartas = mysqli_query($conexion, $cadena_cartas);
$cuerpo ="";
if ($solo_lectura!='') {
	$disabled = 'display:none';
}else{
	$disabled='';
}
$i=0;
while ($row_cartas=mysqli_fetch_array($consulta_cartas)) {
	$i++;
	$detalle="<a href='#' onclick='detalle(\"$row_cartas[9]\",\"$row_cartas[4]\",$row_cartas[1])'>$row_cartas[1]</a>";
	$liberar = "<a href='javascript:liberar_devolucion($row_cartas[7])' class='btn btn-success' style=$disabled>Liberar</a>";
	array_push($datos,array(
		'no'=>$i,
		'folio'=>$detalle,
		'movimiento'=>$row_cartas[4],
		'proveedor'=>$row_cartas[6],
		'fecha'=>$row_cartas[3],
		'sucursal'=>$row_cartas[0],
		'usuario'=>$row_cartas[8],
		'liberar'=>$liberar
	));
}
echo utf8_encode(json_encode($datos));
?>