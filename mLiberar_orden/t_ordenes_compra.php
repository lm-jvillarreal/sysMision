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
							DATE_FORMAT(orden_compra.fecha_llegada, '%d/%m/%Y'),
							DATEDIFF(curdate(), fecha_llegada),
							orden_compra.ruta,
							proveedores.id,
							orden_compra.id_sucursal,
							sucursales.nombre,
							orden_compra.hora_inicio,
							orden_compra.comentarios,
							orden_compra.tipo
					FROM
							proveedores
					INNER JOIN orden_compra ON proveedores.numero_proveedor = orden_compra.id_proveedor
					INNER JOIN sucursales ON sucursales.id = orden_compra.id_sucursal
					WHERE orden_compra.activo = '1'".
					$filtro_sucursal.
					"AND orden_compra.hora_inicio IS NULL
					AND (orden_compra.tipo = '1' or orden_compra.tipo ='2')
					ORDER BY
					orden_compra.fecha_llegada ASC";

//echo $cadena_ordenes;
$consulta_ordenes = mysqli_query($conexion, $cadena_ordenes);
$cuerpo = "";

while ($row_ordenes = mysqli_fetch_array($consulta_ordenes)) {
	if($row_ordenes[12]=='1'){
		$nOrden=str_replace ( "BO -", "" , $row_ordenes[2]);
		$ruta = "pdfEjemplo/index.php?id=".$nOrden;
		$class = "btn btn-success";
		$style = "";
	}elseif($row_ordenes[12]=='2'){
		$ruta="../mOrden_compra/docs/".intval($row_ordenes[2]).".xlsx";
		$class = "btn btn-danger";
		$style = "";
	}elseif($row_ordenes[12]=='3'){
		$ruta='#';
		$style = "style=visibility:none";
	}
	$dias_retraso = ($row_ordenes[5] < 0) ? "0" : $row_ordenes[5];
	//$ruta = "pdfEjemplo/index.php?id=$row_ordenes[2]";
	
	$ver = "<center><a href='$ruta' class='$class' target='blank' $style>Ver</a></center>";
	$liberar = "<center><a href='#' onclick='iniciar_liberacion($row_ordenes[3])'><i class='fa fa-toggle-right fa-3x' style='color: #DF0101;'></i></a></center>";

	$renglon = "
		{
		\"folio\": \"$row_ordenes[3]\",
	   \"no_proveedor\": \"$row_ordenes[0]\",
	   \"proveedor\": \"$row_ordenes[1]\",
	   \"no_orden\": \"$row_ordenes[2]\",
	   \"fecha_llegada\": \"$row_ordenes[4]\",
	   \"retraso\": \"$dias_retraso\",
	   \"sucursal\": \"$row_ordenes[9]\",
	   \"ver\": \"$ver\",
	   \"liberar\": \"$liberar\"
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
