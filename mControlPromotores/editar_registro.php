<?php
	include '../global_seguridad/verificar_sesion.php';
	include '../global_settings/conexion_oracle.php';
	
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("H:i:s");

	$id = $_POST['id_promotor'];
	$cadena = mysqli_query($conexion,"SELECT id,
											nombre,
											ap_paterno,
											compañia,
											telefono,
											clave_proveedor,
											id_comprador,
											(SELECT CONCAT(personas.nombre,' ',personas.ap_paterno) 
												FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona 
												WHERE usuarios.id = promotores.id_comprador
											),
											frecuencia,
											celular
						              FROM promotores
						              WHERE activo = '1' 
						              AND id = '$id'");

	$row    = mysqli_fetch_array($cadena);

	$cadena_proveedores = "SELECT PR.PROC_CVEPROVEEDOR, CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR = '$row[5]'";
    
    $consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
    oci_execute($consulta_proveedores);
    $row_proveedores=oci_fetch_row($consulta_proveedores);

	$clave_proveedor  = ($row[5] == "")?"":$row[5];
	$nombre_proveedor = ($row_proveedores[1] == "")?"":$row_proveedores[1];
	$id_comprador     = ($row[6] == "")?"":$row[6];
	$nombre_comprador = ($row[7] == "")?"":$row[7];
	
	$array  = array($row[0], //id
					$row[1], //nombre
					$row[2], //apellido
					$row[3], //compañia
					$row[4], //telefono
					$clave_proveedor, //clave_proveedor
					$nombre_proveedor, //nombre_proveedor
					$id_comprador, //id_comprador
					$nombre_comprador, //nombre_comprador
					$row[8], //frecuencia
					$row[9] //celular
				);
	$array1 = json_encode($array);
	echo $array1;
?>