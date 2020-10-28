<?php
	include '../global_seguridad/verificar_sesion.php';
	include '../global_settings/conexion_oracle.php';
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

	$id = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT id_proveedor,nombre_encargado,fecha_servicio,gasto,supervisor,
	(SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ', personas.ap_materno) FROM personas INNER JOIN usuarios ON usuarios.id_persona = personas.id WHERE usuarios.id = bitacora_servicios.supervisor) AS Supervisor,id_rublo,(SELECT nombre FROM rublos WHERE rublos.id = bitacora_servicios.id_rublo), comentario, id_sucursal, (SELECT nombre FROM sucursales WHERE sucursales.id = bitacora_servicios.id_sucursal)
	FROM bitacora_servicios 
	WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena);

	$cadena_proveedores = "SELECT PR.PROC_CVEPROVEEDOR, CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR = '$row[0]'";
    $consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
    oci_execute($consulta_proveedores);
    $row_proveedores=oci_fetch_row($consulta_proveedores);

	$array = array($row[0], ///id_proveedor
					$row_proveedores[1], ///nombre_proveedor
					$row[1], ///nombre_encargado
					$row[2], ///fecha_servicio
					$row[3], ///gasto
					$row[4], ///id_sup
					$row[5], ///supervisor
					$row[6], ///id_rublo
					$row[7], ///rublo
					$row[8], ///comentario
					$row[9], ///comentario
					$row[10], ///comentario
				);

	$array1 = json_encode($array);
	echo $array1;	
?>