<?php
	include '../global_seguridad/verificar_sesion.php';
  	include '../global_settings/conexion_oracle.php';

  	$id = $_POST['id'];
  	$cadena = mysqli_query($conexion,"SELECT tipo, nombre_proveedor, proveedor, fecha_entrega, plazo_dias, descuento, garantias FROM proveedores_cotizacion WHERE id = '$id'");
  	$row = mysqli_fetch_array($cadena);

  	$cadena2 = "SELECT PR.PROC_CVEPROVEEDOR, CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE pr.PROC_CVEPROVEEDOR = '$row[2]'";
    $consulta_proveedores = oci_parse($conexion_central, $cadena2);
    oci_execute($consulta_proveedores);
    $row_proveedores=oci_fetch_row($consulta_proveedores);

    $array = array($row[0], //tipo
    				$row[1], //np
    				$row[2], //p
    				$row_proveedores[1], //np
    				$row[3], //fe
    				$row[4], //pd
    				$row[5], //desc
    				$row[6] //garantias
    				);
    echo json_encode($array);
?>