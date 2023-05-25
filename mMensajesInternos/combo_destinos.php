<?php
	include '../global_settings/conexion.php';
	if(!empty($_POST['folio'])){
	    $folio = $_POST['folio'];
	}else{
		$folio = "";
	}
	$cadena_permisos = "SELECT u.id_persona, u.nombre_usuario, CONCAT(p.nombre, ' ',p.ap_paterno, ' ', p.ap_materno) FROM usuarios u INNER JOIN personas p ON u.id_persona = p.id WHERE u.activo = '1'and u.id_perfil = '5'  OR u.id_persona = '3'  OR u.id_persona = '165'";
	//trae el id y el nombre del comprador						
	$consulta_permisos = mysqli_query($conexion, $cadena_permisos);
	 
	while ($row_permisos = mysqli_fetch_row($consulta_permisos)) {
		
		//$cadena = "SELECT fa.id_permiso FROM firmas_autorizadas fa INNER JOIN permisos p ON p.id_permiso= fa.id_permiso WHERE folio = '$folio'";
		echo "<option value='$row_permisos[0]'>$row_permisos[2]</option>";
		//echo $row_permisos[0];
  	}
  	$cadena = mysqli_query($conexion,"SELECT fa.id_permiso, p.nombre FROM firmas_autorizadas fa INNER JOIN permisos p ON p.id = fa.id_permiso WHERE  p.activo = '1'");
  	while ($row_seleccionadas = mysqli_fetch_array($cadena)) {
  		echo "<option value=\"$row_seleccionadas[0]\" selected>$row_seleccionadas[1]</option>";
  	}
?>