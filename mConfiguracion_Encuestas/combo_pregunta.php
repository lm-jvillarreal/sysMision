<?php
	include '../global_settings/conexion.php';
	$departamento = $_POST['valor'];

	$cadena = "SELECT id,pregunta FROM preguntas WHERE activo = '1' AND id_departamento = '$departamento'";
	$consulta = mysqli_query($conexion, $cadena);
	 $opciones = "<option selected></option>";
	while ($row = mysqli_fetch_row($consulta)) {
			$opciones .= "<option value='$row[0]'>$row[1]</option>";
  	}
  	echo $opciones;
?>