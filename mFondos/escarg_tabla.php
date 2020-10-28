<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$anio = '2019';
$filtro_rp = (!empty($registros_propios) == '1') ? " WHERE id_comprador = '$id_usuario'" : "";

$cadena_aportaciones = "SELECT 
                          id, 
                          tipo_movimiento, 
                          folio_movimiento, 
                          fecha_afectacion, 
                          id_sucursal,
                          nombre_proveedor,
                          comentarios,
                          id_comprador,
                          concepto,
                          CONCAT('$',FORMAT(total,2)),
                          consecutivo_nc,
                          cve_proveedor
                        FROM 
                          fondos".$filtro_rp;

//echo $cadena_aportaciones;
$consulta_aportaciones = mysqli_query($conexion, $cadena_aportaciones);

$cuerpo ="";

while ($row_aportaciones = mysqli_fetch_array($consulta_aportaciones)) {
	$link_detalle="";
	$cadena_comprador = "SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno)
						FROM usuarios 
						INNER JOIN personas 
						WHERE usuarios.id_persona = personas.id 
						AND usuarios.id = '$row_aportaciones[7]'";
	$consulta_compradores = mysqli_query($conexion, $cadena_comprador);
	$row_comprador = mysqli_fetch_array($consulta_compradores);

	if ($row_aportaciones[1]=="NC") {
		$link_detalle = "<center><a href='#' data-id = '$row_aportaciones[2]' data-consec = '$row_aportaciones[10]' data-toggle = 'modal' data-target = '#modal-nc' class='btn btn-danger' target='blank'>$row_aportaciones[2]</a></center>";
	}elseif($row_aportaciones[1]=="ESCARG"){
		$link_detalle = "<center><a href='#' data-id = '$row_aportaciones[2]' data-mov = '$row_aportaciones[1]' data-suc = '$row_aportaciones[4]' data-toggle = 'modal' data-target = '#modal-escarg' class='btn btn-danger' target='blank'>$row_aportaciones[2]</a></center>";
	}elseif($row_aportaciones[1]=="MANUAL"){
		$link_detalle = "<center><a href='#' data-id = '$row_aportaciones[0]' data-mov = '$row_aportaciones[1]' data-suc = '$row_aportaciones[4]' data-toggle = 'modal' data-target = '#modal-manual' class='btn btn-danger' target='blank'>$row_aportaciones[2]</a></center>";
	}
	$link_comentario = "<center><a href='#' data-id = '$row_aportaciones[0]' data-toggle = 'modal' data-target = '#modal-comentario' class='btn btn-danger' target='blank'>Editar</a></center>";
	$renglon = "
		{
		\"tipo_movimiento\": \"$row_aportaciones[1]\",
		\"folio_movimiento\": \"$link_detalle\",
		\"fecha_afectacion\": \"$row_aportaciones[3]\",
		\"sucursal\": \"$row_aportaciones[4]\",
		\"cve_proveedor\": \"$row_aportaciones[11]\",
		\"proveedor\": \"$row_aportaciones[5]\",
		\"comentarios\": \"$row_aportaciones[6]\",
		\"comprador\": \"$row_comprador[0]\",
		\"concepto\": \"$row_aportaciones[8]\",
		\"valor\": \"$row_aportaciones[9]\",
		\"editar_comentario\": \"$link_comentario\"
		},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>