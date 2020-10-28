<?php 
	include '../global_settings/conexion.php';
	$factura = $_POST['factura'];
	$folio_mov = $_POST['folio_mov'];
	$tipo_mov = $_POST['tipo_mov'];
	$sucursal = $_POST['sucursal'];
	$total_entrada = $_POST['total_entrada'];
	$id = $_POST['id'];
	$select = "SELECT diferencia_restante FROM notas_entrada WHERE id = $id";
	$exSelect = mysqli_query($conexion, $select);
	$row = mysqli_fetch_row($exSelect);
	$dif_restante = $row[0] - $total_entrada;

	$sql = "INSERT INTO notas_entrada (
										folio_mov, 
										tipo_mov, 
										id_sucursal, 
										total_entrada, 
										total_factura, 
										diferencia, 
										factura, 
										diferencia_restante, 
										proveedor, 
										fecha)
										 VALUES (
										'$folio_mov', 
										'$tipo_mov', 
										'$sucursal', 
										'$total_entrada', 
										'0', 
										'$row[0]', 
										'$factura', 
										'$dif_restante', 
										'$proveedor', 
										'$fecha')";
	$exSql = mysqli_query($conexion, $sql);
	echo "$sql";
	$up = "UPDATE notas_entrada SET diferencia_restante = diferencia_restante - $total_entrada WHERE id '$id'";
	$exUp = mysqli_query($conexion, $up);
 ?>