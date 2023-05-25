<?php
	// esto permite tener acceso desde otro servidor
		header('Access-Control-Allow-Origin: *');
	// esto permite tener acceso desde otro servidor
	include '../global_settings/consulta_sqlsrvr.php';

	if(!isset($_POST['searchTerm'])){ 
		$cadena_persona = "SELECT codigo, (cast(codigo as varchar) + ' - ' + nombre + ' ' + ap_paterno + ' ' + ap_materno) AS 'nombre' FROM empleados WHERE activo = 'S'";
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
	 $data[] = array("id"=>$row['nombre'], "text"=>$row['nombre']);
	}
	echo json_encode($data);
?>