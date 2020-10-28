<?php
	include '../global_settings/conexion.php';
	if(!empty($_POST['folio'])){
	    $folio = $_POST['folio'];
	}else{
		$folio = "";
	}
	$cadena_departamentos = "SELECT id,nombre
							FROM departamentos AS d
							WHERE NOT EXISTS (
												SELECT
													*
												FROM
													preguntas AS p
												WHERE
													d.id= p.id_departamento
												AND p.folio= '$folio'
											);";
	$consulta_departamentos = mysqli_query($conexion, $cadena_departamentos);
	 
	while ($row_departamentos = mysqli_fetch_row($consulta_departamentos)) {
		$cadena = "SELECT p.id_departamento FROM preguntas p INNER JOIN departamentos d ON d.id = p.id_departamento WHERE folio = '$folio'";
		echo "<option value='$row_departamentos[0]'>$row_departamentos[1]</option>";
  	}
  	$cadena = mysqli_query($conexion,"SELECT p.id_departamento, d.nombre FROM preguntas p INNER JOIN departamentos d ON d.id = p.id_departamento WHERE p.folio = '$folio' AND p.activo = '1'");
  	while ($row_seleccionadas = mysqli_fetch_array($cadena)) {
  		echo "<option value=\"$row_seleccionadas[0]\" selected>$row_seleccionadas[1]</option>";
  	}
?>