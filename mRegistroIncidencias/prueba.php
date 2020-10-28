<?php
	include '../global_settings/consulta_sqlsrvr.php';

	$cadena = "SELECT e.codigo, e.nombre+' '+e.ap_paterno+' '+ap_materno as Empleado, c.nomdepto,k.centro
				FROM empleados AS e INNER JOIN Llaves AS k
				ON e.codigo = k.codigo
				AND e.empresa = k.empresa
				INNER JOIN centros as c ON k.centro = c.centro
				
				AND (e.empresa <> '4' AND e.empresa <> '5')
				AND (k.empresa <> '4' AND k.empresa <> '5')
				AND (c.empresa <> '4' AND c.empresa <> '5')";
	$consulta_persona = sqlsrv_query($conn, $cadena);
	$data = array();
	while ($row = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC)) {
		echo $row['codigo'].'-'.$row['Empleado'].'-'.$row['nomdepto'].'-'.$row['centro'].'<br>';
	}
?>