<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$anio = '2019';
$filtro_rp = (!empty($registros_propios) == '1') ? " AND id_comprador = '$id_usuario'" : "";

$cadena_solicitud = "SELECT so.id, so.concepto, so.usuario_solicita, suc.nombre, prov.proveedor, so.estatus, so.folio, CONCAT('$',FORMAT(so.monto,2)), so.impuesto
FROM solicitud_nc as so
INNER JOIN sucursales as suc ON so.sucursal = suc.id
INNER JOIN proveedores as prov ON so.proveedor = prov.numero_proveedor
WHERE anio = '2019'";

$consulta_solicitud = mysqli_query($conexion, $cadena_solicitud);

$cuerpo ="";

while ($row_solicitud = mysqli_fetch_array($consulta_solicitud)) {
	$cadena_comprador = "SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno)
						FROM usuarios 
						INNER JOIN personas 
						WHERE usuarios.id_persona = personas.id 
						AND usuarios.id = '$row_solicitud[2]'";
	$consulta_compradores = mysqli_query($conexion, $cadena_comprador);
	$row_comprador = mysqli_fetch_array($consulta_compradores);

    if($row_solicitud[5]=='1'){
		$estatus = "<center><span class='label label-warning'>Pendiente</span></center>";
		$liberar = "<div class='input-group' style='width:72%''><input type='text' id='folio_$row_solicitud[0]' class='form-control' value='$row_solicitud[6]'><span class='input-group-btn'><button onclick='asocia($row_solicitud[0])' class='btn btn-success' type='button'><i class='fa fa-save fa-lg' aria-hidden='true'></i></button></span></div>";
		$eliminar = "<button id='eliminar' name='eliminar' onclick='eliminar($row_solicitud[0])' class='btn btn-danger btn-md'><i class='fa fa-trash-o fa-lg'></i></button></center>";
	}elseif($row_solicitud[5] =='2'){
		$estatus = "<center><span class='label label-success'>Asociado</span></center>";
		$liberar = $row_solicitud[6];
		$eliminar = "";
	}

	$renglon = "
		{
		\"id\": \"$row_solicitud[0]\",
		\"concepto\": \"$row_solicitud[1]\",
		\"comprador\": \"$row_comprador[0]\",
		\"sucursal\": \"$row_solicitud[3]\",
		\"proveedor\": \"$row_solicitud[4]\",
		\"monto\": \"$row_solicitud[7]\",
		\"impuesto\": \"$row_solicitud[8]\",
		\"estatus\": \"$estatus\",
		\"liberar\": \"$liberar $eliminar\"
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