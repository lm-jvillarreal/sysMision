<?php 
	//include '../configuracion/conexion_servidor.php';
	include '../global_settings/conexion_oracle.php';
	///////////////////////consulta de informacion///////////////////
	$codigo = $_POST['codigos'];
	$cantidad = $_POST['cantidades'];
	$array_codigo = explode(',', $codigo);
	$array_cantidad = explode(',', $cantidad);
	$cantidad = count($array_codigo);
	$folio = $_POST['folio'];
	$sucursal = $_POST['sucursal'];
	$movimiento = $_POST['movimiento'];

	for ($i=0; $i < $cantidad; $i++) { 
		$select = "SELECT
				ARTC_ARTICULO,
				MCOC_CLAVEGASTO,
				ARTC_UNIMEDIDA_USO
			FROM
				COM_ARTICULOS
			WHERE
				ARTC_ARTICULO = '$array_codigo[$i]'";
		$st = oci_parse($conexion_central, $select);
		oci_execute($st);
		$row = oci_fetch_row($st);
		$insert = "INSERT INTO INV_RENGLONES_MOVIMIENTOS (
						CTBS_CIA,
						ALMN_ALMACEN,
						MODC_TIPOMOV,
						MODN_FOLIO,
						ARTC_ARTICULO,
						RMOC_UNIMEDIDA,
						RMOC_CVEGASTO,
						RMON_ESTATUS,
						RMON_CANTSURTIDA
					)
					VALUES
						(
							'1',
							'$sucursal',
							'$movimiento',
							'$folio',
							'$array_codigo[$i]',
							'$row[2]',
							'$row[1]',
							1,
							'$array_cantidad[$i]'
						)";
						echo $insert;
				$st_insert = oci_parse($conexion_central, $insert);
				oci_execute($st_insert);
	}
 ?>