<?php
	include '../global_seguridad/verificar_sesion.php';
	include '../global_settings/conexion_oracle.php';

	$id_material = $_POST['id'];

	$cadena = mysqli_query($conexion,"SELECT nombre, descripcion, id_sucursal, (SELECT nombre FROM sucursales WHERE sucursales.id = catalogo_materiales2.id_sucursal), existencia, tipo, proveedor, id_tipo_bodega, (SELECT nombre FROM tipo_bodega WHERE tipo_bodega.id = catalogo_materiales2.id_tipo_bodega) FROM catalogo_materiales2 WHERE id = '$id_material'");
	$row = mysqli_fetch_array($cadena);

	if($row[5] == 1){
		$cadena_proveedores = "SELECT PR.PROC_CVEPROVEEDOR, CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR = '$row[6]'";
		$consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
    	oci_execute($consulta_proveedores);
    	$row_proveedores=oci_fetch_row($consulta_proveedores);
    	$nombre_proveedor = $row_proveedores[1];
	}else{
		$nombre_proveedor = "";
	}

	$array = array($row[0], //Nombre
				   $row[1], //Descripcion
				   $row[2], //Id_sucursal
				   $row[3], //Nombre_sucursal
				   $row[4], //Existecia
				   $row[5], //Tipo
				   $row[6], //Proveedor
				   $nombre_proveedor, //Infofin
				   $row[7],
				   $row[8]
				);
	echo json_encode($array);
?>