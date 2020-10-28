<?php 
	include '../global_seguridad/verificar_sesion.php';
	include "../global_settings/conexion_oracle.php";

	$folio = $_POST['no_folio'];
	$movimiento = $_POST['tipo_mov'];
	$sucursal = $_POST['sucursal'];
	//echo "$sucursal";
	if ($sucursal == "") {
		$sucursal = $id_sede;
		$nombre_sucursal = $nombre_sede;
	}else{
		$sucursal = $sucursal;
		$cadena_sucCons = "SELECT nombre FROM sucursales WHERE id = '$sucursal'";
		$consulta_sucCons = mysqli_query($conexion, $cadena_sucCons);
		$row_sucCons = mysqli_fetch_array($consulta_sucCons);
		$nombre_sucursal = $row_sucCons[0];
	}
	$sql = "SELECT
				MODC_TIPOMOV,
				MODN_FOLIO,
				MOVC_REFERENCIA,
				MOVD_FECHAAFECTACION,
				MOVC_NOTAENTRADA,
				MOVC_CVEPROVEEDOR,
				MOVC_CXP_REMISION,
				ALMN_ALMACEN
			FROM
				INV_MOVIMIENTOS
			WHERE
				MODN_FOLIO = '$folio'
			AND MODC_TIPOMOV = '$movimiento'
			AND ALMN_ALMACEN = '$sucursal'";
			//echo "$sql";
	$st = oci_parse($conexion_central, $sql);
	oci_execute($st);
	$row = oci_fetch_row($st);
	$prov = "SELECT
				PROC_NOMBRE
			FROM
				CXP_PROVEEDORES
			WHERE
				PROC_CVEPROVEEDOR = '$row[5]'";

	$sr_prov = oci_parse($conexion_central, $prov);
	oci_execute($sr_prov);
	$row_prov = oci_fetch_row($sr_prov);
	$array = array(
				$row[0],
				$row[1],
				$row[2],
				$row[3],
				$row[4],
				$row[5],
				$row[6],
				$row_prov[0],
				$row[7],
				$sucursal,
				$nombre_sucursal
				);
	$array_datos = json_encode($array);
	echo "$array_datos";
 ?>