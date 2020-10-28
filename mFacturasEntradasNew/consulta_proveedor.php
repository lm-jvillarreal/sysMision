<?php 
	include '../global_settings/conexion.php';
	include '../global_settings/conexion_oracle.php';
	  $folio = $_POST['folio'];
    $movimiento = $_POST['movimiento'];
    $almacen = $_POST['sucursal'];

		$qry = "SELECT
              CXP_PROVEEDORES.PROC_NOMBRE
			FROM
				INV_movimientos
			INNER JOIN CXP_PROVEEDORES ON TRIM(CXP_PROVEEDORES.PROC_CVEPROVEEDOR) = INV_MOVIMIENTOS.MOVC_CVEPROVEEDOR
            WHERE
              MODN_FOLIO = '$folio'
            AND ALMN_ALMACEN = '$almacen'
            AND MODC_TIPOMOV = '$movimiento'";
             //echo "$qry";
      $st = oci_parse($conexion_central, $qry);
      oci_execute($st);
      $row = oci_fetch_row($st);
      echo "$row[0]";
 ?>