<?php 
	include '../global_settings/conexion.php';
	$pIdCarta = $_POST['id'];
	$sql = "SELECT
				carta_faltante.no_factura,
				sucursales.nombre,
				fecha_elaboracion,
				tipo_orden,
				no_orden,
				proveedores.proveedor,
				carta_faltante.total_diferencia
			FROM
				carta_faltante
				INNER JOIN proveedores ON proveedores.numero_proveedor = carta_faltante.numero_proveedor
				INNER JOIN sucursales ON sucursales.id = carta_faltante.id_sucursal
			WHERE
				carta_faltante.id = '$pIdCarta'";

	$exSql = mysqli_query($conexion, $sql);
	$row = mysqli_fetch_row($exSql);
	echo json_encode($row);
 ?>