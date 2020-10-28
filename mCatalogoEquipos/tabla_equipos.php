<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$cadena_catalogoEquipo = "SELECT mtto_catalogo_equipos.id,
					   mtto_catalogo_equipos.codigo_interno,
		               CONCAT(mtto_catalogo_equipos.equipo,' ',mtto_catalogo_equipos.marca,' ',mtto_catalogo_equipos.modelo,', Serie ',mtto_catalogo_equipos.no_serie) AS Descripcion,
		               mtto_grupo.grupo,
		               sucursales.nombre,
		               areas_mantenimiento.nombre,
		               mtto_tipo_equipo.tipo_equipo
				 FROM mtto_catalogo_equipos 
				 INNER JOIN mtto_grupo ON mtto_catalogo_equipos.id_grupo = mtto_grupo.id
				 INNER JOIN sucursales ON mtto_catalogo_equipos.sucursal = sucursales.id
				 INNER JOIN areas_mantenimiento ON mtto_catalogo_equipos.id_area = areas_mantenimiento.id
				 INNER JOIN mtto_tipo_equipo ON mtto_catalogo_equipos.id_tipoEquipo = mtto_tipo_equipo.id";
$consulta_catalogoEquipo = mysqli_query($conexion, $cadena_catalogoEquipo);

$cuerpo ="";

while ($row_catalogoEquipo = mysqli_fetch_array($consulta_catalogoEquipo)) {
	$link = "<button class='btn btn-danger btn-sm' data-id='$row_catalogoEquipo[0]' data-toggle='modal' data-target='#modal-imagenes'><i class='fa fa-file-photo-o fa-2x'></i></button>&nbsp;<button class='btn btn-primary btn-sm' data-id='$row_catalogoEquipo[0]' data-toggle='modal' data-target='#modal-archivos'><i class='fa fa-file-pdf-o fa-2x'></i></button>";
	$renglon = "
		{
		\"num\": \"$row_catalogoEquipo[0]\",
		\"clave\": \"$row_catalogoEquipo[1]\",
		\"equipo\": \"$row_catalogoEquipo[2]\",
		\"sucursal\": \"$row_catalogoEquipo[4]\",
		\"grupo\": \"$row_catalogoEquipo[3]\",
		\"tipo\": \"$row_catalogoEquipo[6]\",
		\"area\": \"$row_catalogoEquipo[5]\",
		\"adjuntar\": \"$link\"
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
