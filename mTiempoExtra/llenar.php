<?php
	include '../global_settings/conexion.php';
	include '../global_settings/consulta_sqlsrvr.php';

	// esto permite tener acceso desde otro servidor
		//header('Access-Control-Allow-Origin: *');
	// esto permite tener acceso desde otro servidor

	$id_registro = $_POST['id_registro'];
	$id_persona = $_POST['id_persona'];

	$cadena_persona = "SELECT
							campo__14,
							campo__15 
						FROM
							clasificacion_empleados AS clase
							INNER JOIN empleados ON clase.codigo= empleados.codigo 
							AND clase.empresa= empleados.empresa 
						WHERE
							empleados.codigo = '$id_persona' 
							AND (
							clase.empresa= 4 
							OR clase.empresa= 7 OR clase.empresa=8) AND activo='S'";
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