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
					DATEDIFF( curdate( ), fecha_llegada),
					orden_compra.ruta,
					proveedores.id,
					sucursales.nombre,
					orden_compra.hora_inicio,
					orden_compra.comentarios,
					orden_compra.tipo
				FROM
					orden_compra
					INNER JOIN proveedores ON orden_compra.id_proveedor = proveedores.numero_proveedor
					INNER JOIN sucursales ON orden_compra.id_sucursal = sucursales.id
					WHERE orden_compra.activo = '1' AND orden_compra.id_proveedor<>''
					".$filtro_sucursal."
					AND orden_compra.STATUS = '1'
					ORDER BY
					orden_compra.fecha_llegada ASC";

$consulta_ordenes = mysqli_query($conexion, $cadena_ordenes);
$cuerpo = "";

while ($row_ordenes = mysqli_fetch_array($consulta_ordenes)) {

	$entcoc = ($row_ordenes[11] == '2') ? "style='visibility:hidden'" : "";
	$dias_retraso = ($row_ordenes[5] < 0) ? "0" : $row_ordenes[5];
	$ruta = "pdfEjemplo/index.php?id=$row_ordenes[2]";

	$ver = "<center><a href=$ruta class='btn btn-success' target='blank' $entcoc>Ver</a></center>";
	$liberar = "<center><a href='liberar_orden.php?id_orden=$row_ordenes[3]' class='btn btn-danger'>Liberar</a></center>";
	$escape_prov=mysqli_real_escape_string($conexion,$row_ordenes[1]);
	$renglon = "
		{
			\"folio\": \"$row_ordenes[3]\",
			\"no_proveedor\": \"$row_ordenes[0]\",
			\"proveedor\": \"$escape_prov\",
			\"no_orden\": \"$row_ordenes[2]\",
			\"fecha_llegada\": \"$row_ordenes[4]\",
			\"retraso\": \"$row_ordenes[5]\",
			\"sucursal\": \"$row_ordenes[8]\",
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
?>