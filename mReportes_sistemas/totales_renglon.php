<?php 
	//include '../global_settings/conexion.php';
	include '../global_settings/conexion.php';
	$codigo        = $_POST['codigo'];
	echo "$codigo[0]";
	$referencia  = $_POST['referencia'];
	$cantidad    = $_POST['cantidad'];
	$tipo        = $_POST['tipo'];
	$descripcion = $_POST['descripcion'];
	$c_do        = $_POST['c_do'];
	$c_arb       = $_POST['c_arb'];
	$c_vil       = $_POST['c_vil'];
	$c_all       = $_POST['c_all'];
	$c_petaca = $_POST['c_petaca'];
	$c_total     = $_POST['c_total'];
	$c_diff      = $_POST['c_diff'];
	$fecha1      = $_POST['fecha_inicial'];
	$fecha2      = $_POST['fecha_final'];

	$sql_ref = "INSERT INTO referencias_recargas (referencia, fecha, tipo,fecha1,fecha2) VALUES('$referencia', CURRENT_DATE, '$tipo','$fecha1','$fecha2')";
	$exR = mysqli_query($conexion, $sql_ref);
	$sel = "SELECT MAX(id) FROM referencias_recargas";
	$exSel = mysqli_query($conexion, $sel);
	$row = mysqli_fetch_row($exSel);
	for ($i=0; $i < count($cantidad); $i++) { 
		$sql = "INSERT INTO renglones_referencia (id_referencia, codigo, total, descripcion, c_do, c_vil, c_arb, c_all, c_total,diferencia, c_petaca) VALUES('$row[0]', '$codigo[$i]', '$cantidad[$i]', '$descripcion[$i]', '$c_do[$i]', '$c_vil[$i]', '$c_arb[$i]', '$c_all[$i]', '$c_total[$i]','$c_diff[$i]', '$c_petaca')";
		$exSql = mysqli_query($conexion, $sql);
		//echo "$sql";
	}
 ?>