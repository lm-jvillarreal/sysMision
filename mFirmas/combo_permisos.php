<?php
	include '../global_settings/conexion.php';
	if(!empty($_POST['folio'])){
	    $folio = $_POST['folio'];
	}else{
		$folio = "";
	}
	$cadena_permisos = "SELECT id_permiso,nombre FROM permisos WHERE activo = '1'";
							
	$consulta_permisos = mysqli_query($conexion, $cadena_permisos);
	 
	while ($row_permisos = mysqli_fetch_row($consulta_permisos)) {
		$cadena = "SELECT fa.id_permiso FROM firmas_autorizadas fa INNER JOIN permisos p ON p.id_permiso= fa.id_permiso WHERE folio = '$folio'";
		echo "<option value='$row_permisos[0]'>$row_permisos[1]</option>";
  	}
  	$cadena = mysqli_query($conexion,"SELECT fa.id_permiso, p.nombre FROM firmas_autorizadas fa INNER JOIN permisos p ON p.id = fa.id_permiso WHERE  p.activo = '1'");
  	while ($row_seleccionadas = mysqli_fetch_array($cadena)) {
  		echo "<option value=\"$row_seleccionadas[0]\" selected>$row_seleccionadas[1]</option>";
  	}
?>