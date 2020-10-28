<?php
	include '../global_seguridad/verificar_sesion.php';

	$cadena = mysqli_query($conexion,"SELECT id,nombre FROM solicitud_etiquetas WHERE estatus = '2' AND fecha != '$fecha'");
	$numero = 0;
	while ($row = mysqli_fetch_array($cadena)) {
		$cadena2 = mysqli_query($conexion,"SELECT folio,title FROM agenda WHERE title LIKE '$row[0]%'");
		$existe = mysqli_num_rows($cadena2);
		if($existe != 0){
			$row2 = mysqli_fetch_array($cadena2);
			$cadena_eliminar = mysqli_query($conexion,"DELETE FROM agenda WHERE folio = '$row2[0]'");
			$numero ++;
		}
	}
	echo $numero;
?>