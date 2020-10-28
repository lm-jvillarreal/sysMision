<?php 
	//include'../global_settings/conexion.php';
	include '../global_seguridad/verificar_sesion.php';
    date_default_timezone_set("America/Monterrey");
    $pIdMapeo = $_POST['id_mapeo'];
    //$fecha = $_POST['fecha_conteo'];

	$qry = "UPDATE inv_mapeo 
			SET activo = 0,
			fecha_conteo = current_date,
			contador = 6,
			captura = '$id_usuario'
			WHERE
				inv_mapeo.id ='$pIdMapeo'";

	echo "$qry";

	$exQry = mysqli_query($conexion, $qry);
 ?>