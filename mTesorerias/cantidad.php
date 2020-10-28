<?php
	include '../global_seguridad/verificar_sesion.php';

	$folio = $_POST['folio'];
	$cadena1 = mysqli_query($conexion,"SELECT MIN(id),MAX(id),id,concepto,cantidad FROM otros  WHERE folio = '$folio'ORDER BY id ASC ");
	$cant    = mysqli_num_rows($cadena1);
	$row   = mysqli_fetch_array($cadena1);

	$array = array($cant,$row[0],$row[1]);
	$array1 = json_encode($array);
	
	echo $array1;
?>