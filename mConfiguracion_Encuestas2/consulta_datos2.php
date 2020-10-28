<?php
  	include '../global_seguridad/verificar_sesion.php';

	$id_trabajador = $_POST['id_trabajador'];
	$folio         = $_POST['folio'];

	$cadena = mysqli_query($conexion,"SELECT nombre_completo FROM trabajadores_sql WHERE codigo = '$id_trabajador'");
	$row = mysqli_fetch_array($cadena);

  	$cadena2 = mysqli_query($conexion,"SELECT nombre FROM n_encuestas WHERE folio = '$folio'");
  	$row2 = mysqli_fetch_array($cadena2);

  	$array = array($row[0],$row2[0]);

  	echo json_encode($array);
?>
