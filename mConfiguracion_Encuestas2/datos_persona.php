<?php
	include '../global_settings/conexion.php';
	include '../global_settings/consulta_sqlsrvr.php';


	$codigo = $_POST['codigo'];
	$cadena_persona = "SELECT campo__14, campo__15 FROM clasificacion_empleados as clase 
					   INNER JOIN empleados ON clase.codigo=empleados.codigo WHERE empleados.codigo = '$codigo'
					   AND (
							clase.empresa= 4 
							OR clase.empresa= 7)";
					   //campo__14: sucursal
					   //campo__15: departamento
					   //codigo:    numero de empleado
	$consulta_persona = sqlsrv_query($conn, $cadena_persona);
	$data = array();
	$row = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);

//separar el array para imprimir por separado, en campos diferentes.
	$array = array($row['campo__14'],$row['campo__15']);
	echo json_encode($array);
?>