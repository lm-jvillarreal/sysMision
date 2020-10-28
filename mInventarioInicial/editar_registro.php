<?php
	include '../global_seguridad/verificar_sesion.php';
	include '../global_settings/conexion_oracle.php';

	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id_registro = $_POST['id_registro'];
	
	$cadena = mysqli_query($conexion,"SELECT
										id_comprador,
										(SELECT CONCAT(
													personas.nombre,
													' ',
													personas.ap_paterno)
											FROM personas
											WHERE personas.id = altas_productos.id_comprador) AS NombreC,
										id_proveedor,
										costo,
										iva,
										ieps,
										img_presentacion,
										img_codigo
									FROM altas_productos
									WHERE id = '$id_registro'");

	$row = mysqli_fetch_array($cadena);

	$cadena_proveedores = "SELECT CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR = '$row[2]'";
	$consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
	oci_execute($consulta_proveedores);
	$row_proveedores=oci_fetch_row($consulta_proveedores);

	$array  = array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row_proveedores[0]);
	$array1 = json_encode($array);
	
	echo $array1;
	
?>