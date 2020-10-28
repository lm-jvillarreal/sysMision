<?php
	include '../global_seguridad/verificar_sesion.php';
	$nada = $_POST['nada'];

	$cadena = mysqli_query($conexion, "SELECT id, fecha_fin, id_promotor FROM vacaciones_promotor WHERE activo = '1'");

	$numero = 0;
	while ($row = mysqli_fetch_array($cadena)) {
		if($fecha <= $row[1]){
			$cadena2 = mysqli_query($conexion,"UPDATE vacaciones_promotor SET activo = '0' WHERE id = '$row[0]'");
			$cadena3 = mysqli_query($conexion,"UPDATE promotores SET activo = '1' WHERE id = '$row[2]'");
			$numero ++;
		}
	}

	echo $numero;
?>