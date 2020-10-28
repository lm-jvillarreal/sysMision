<?php
	include '../global_settings/conexion.php';
	$cadena = "SELECT id,nombre FROM sucursales WHERE activo = '1'";
	$consulta = mysqli_query($conexion, $cadena);
	 $opciones = "<option selected></option>";
	while ($row = mysqli_fetch_row($consulta)) {
			$opciones .= "<option value='$row[0]'>$row[1]</option>";
  	}
  	echo $opciones;
?>