<?php 
	include '../global_settings/conexion.php';
	include "../global_settings/conexion_oracle.php";

	$folio = $_POST['folio'];
	$cadena_od = "SELECT
				NOMBREALMACEN,
				NOMBREPROVEEDOR,
				ORDN_ORDEN,
				PROC_CVEPROVEEDOR,
				LABC_LAB,
					(SELECT TO_CHAR(ROCD_ESTENTREGA, 'YYYY-MM-DD') FROM COM_RENGLONES_ORDENES_COMPRA WHERE COM_ORDENES_COMPRA_VW.ORDN_ORDEN = COM_RENGLONES_ORDENES_COMPRA.ORDN_ORDEN AND ROWNUM = 1),
				ORDN_ESTATUS
			FROM
				COM_ORDENES_COMPRA_VW
			WHERE
				ORDN_ORDEN = '$folio'";

	$sr_prov = oci_parse($conexion_central, $cadena_od);
	oci_execute($sr_prov);

	$row_orden = oci_fetch_row($sr_prov);

	$array_datos  = array(		
						$row_orden[0], //Sucursal
						$row_orden[1], //Proveedor
						$row_orden[2], //Folio Orden
						$row_orden[3], //Clave Proveedor
						$row_orden[4], 
						$row_orden[5], //Fecha llegada
						$row_orden[6] //ESTATUS
					);
	$array_completo = json_encode($array_datos);
	echo "$array_completo";
 ?>