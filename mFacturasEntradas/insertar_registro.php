<?php 
	error_reporting(E_ALL ^ E_NOTICE);
	include '../global_settings/conexion_oracle.php';
    //include '../global_settings/conexion_supsys.php';
    include '../global_settings/conexion.php';
	date_default_timezone_set("America/Monterrey");
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');
	$total_factura = $_POST['total_factura'];
	$total_entrada = $_POST['total_entrada'];
	$sucursal = $_POST['sucursal'];
	$tipo_mov = $_POST['tipo_mov'];
	$folio_mov = $_POST['folio_mov'];
	$factura = $_POST['factura'];
	$proveedor = $_POST['proveedor'];
	$diferencia = $total_factura - $total_entrada;

	$sql = "INSERT INTO notas_entrada (
										folio_mov, 
										tipo_mov, 
										id_sucursal, 
										total_entrada, 
										total_factura, 
										diferencia, 
										factura, 
										diferencia_restante, 
										proveedor, fecha)
										 VALUES (
										'$folio_mov', 
										'$tipo_mov', 
										'$sucursal', 
										'$total_entrada', 
										'$total_factura', 
										'$diferencia', 
										'$factura', 
										'$diferencia', 
										'$proveedor', 
										'$fecha')";

	$exSql = mysqli_query($conexion, $sql);

	$select = "SELECT MAX(id) FROM notas_entrada";
	$exSelect = mysqli_query($conexion, $select);
	$row = mysqli_fetch_row($exSelect);
	$array = array(
				$row[0],
				$diferencia
					);
	$array_datos = json_encode($array);
	echo "$array_datos";
 ?>