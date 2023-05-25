<?php

	  include '../global_settings/conexion.php';
	include '../global_settings/consulta_sqlsrvr.php';

	if(!isset($_POST['searchTerm'])){ 
		$cadena_persona = "SELECT empleados.codigo, clase.campo__15, (cast(empleados.codigo as varchar) + ' - ' + empleados.nombre + ' ' + empleados.ap_paterno + ' ' + empleados.ap_materno) AS 'nombre'
		FROM empleados INNER JOIN clasificacion_empleados AS clase ON clase.codigo= empleados.codigo 
	AND clase.empresa= empleados.empresa  WHERE activo = 'S' AND clase.campo__15 = 'SISTEMAS'";
// 		SELECT
// 	campo__14,
// 	campo__15 
// FROM
// 	clasificacion_empleados AS clase
// 	INNER JOIN empleados ON clase.codigo= empleados.codigo 
// 	AND clase.empresa= empleados.empresa 
// WHERE
// 	empleados.codigo = '$id_persona' 
// 	AND (
// 	clase.empresa= 4 
// 	OR clase.empresa= 7)
	}else{ 
		$search = $_POST['searchTerm'];   
		$cadena_persona = "SELECT codigo, (cast(codigo as varchar) + ' - ' + nombre + ' ' + ap_paterno + ' ' + ap_materno) AS 'nombre'
												FROM empleados 
												WHERE cast(codigo as varchar) + ' - ' + nombre + ' ' + ap_paterno + ' ' + ap_materno LIKE '%$search%'
												AND activo = 'S'";
	}
	$consulta_persona = sqlsrv_query($conn, $cadena_persona);
	$data = array();
	while ($row = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC)) {
	 $data[] = array("id"=>$row['codigo'], "text"=>$row['nombre']);
	}
	echo json_encode($data);
?>

