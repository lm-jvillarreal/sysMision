<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");

$filtro_sucursal = ($solo_sucursal == '1') ? " AND orden_compra.id_sucursal = '$id_sede'" : "";

$cadena_ordenes = "SELECT
	                proveedores.numero_proveedor,
	                proveedores.proveedor,
	                orden_compra.orden_compra,
	                orden_compra.id,
	                orden_compra.fecha_llegada,
	                DATEDIFF(curdate(), fecha_llegada),
	                orden_compra.ruta,
	                proveedores.id,
					orden_compra.id_sucursal,
					sucursales.nombre,
	                orden_compra.hora_inicio,
	                orden_compra.comentarios,
	                orden_compra.tipo,
	                libro_diario.numero_factura
	            FROM
	                proveedores
	            INNER JOIN orden_compra ON proveedores.numero_proveedor = orden_compra.id_proveedor
				INNER JOIN sucursales ON sucursales.id = orden_compra.id_sucursal
	            LEFT JOIN libro_diario ON libro_diario.orden_compra = orden_compra.id
	            WHERE orden_compra.activo = '1' AND orden_compra.STATUS='2' ".
	            $filtro_sucursal.
	            "AND orden_compra.hora_inicio IS NULL
	            GROUP BY(orden_compra.id)
	            ORDER BY
		           orden_compra.fecha_llegada ASC";

$consulta_ordenes = mysqli_query($conexion, $cadena_ordenes);
$cuerpo = "";

while ($row_ordenes = mysqli_fetch_array($consulta_ordenes)) {
	if($row_ordenes[12]=='1'){
		$ver = "<center><a href='orden_compra_pdf/OC - ".$row_ordenes[2].".pdf' class='btn btn-success' target='blank'><i class='fa fa-file-pdf-o'></i></a></center>";

	}else{
		$ver = "<center><a href='docs/".$row_ordenes[2].".xlsx' class='btn btn-danger' target='blank'><i class='fa fa-file-excel-o'></i></a></center>";
	}
	$eliminar = "<center><a href='#' class='btn btn-danger' onclick='eliminar($row_ordenes[3])'><i class='fa fa-trash-o'></i></a></center>";
	$fecha_arribo = "<div class='input-group' style='width:69%'><input type='date' id='fecha_$row_ordenes[3]' class='form-control' value='$row_ordenes[4]'><span class='input-group-btn'><button onclick='actualiza_fecha($row_ordenes[3])' class='btn btn-danger' type='button'><i class='fa fa-floppy-o fa-lg' aria-hidden='true'></i></button></span></div>";
	$proveedor = $row_ordenes[0]." - ".$row_ordenes[1];
	$renglon = "
		{
		\"folio\": \"$row_ordenes[3]\",
		\"proveedor\": \"$proveedor\",
		\"no_orden\": \"$row_ordenes[2]\",
		\"fecha_llegada\": \"$fecha_arribo\",
		\"retraso\": \"$row_ordenes[5]\",
		\"sucursal\": \"$row_ordenes[9]\",
		\"ver\": \"$ver\",
		\"eliminar\": \"$eliminar\"
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
//echo $liberar;
?>