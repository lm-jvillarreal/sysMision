<?php
	include '../global_settings/conexion.php';
	
	$folio = $_POST['folio'];

	$cadena_usuarios = "SELECT u.id,CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno)
						FROM usuarios u
						INNER JOIN personas p ON p.id = u.id_persona
						WHERE NOT EXISTS (SELECT * FROM agenda a WHERE a.id_usuario = u.id AND folio = '$folio')";
	$consulta_usuarios = mysqli_query($conexion, $cadena_usuarios);
	 
	while ($row_usuarios = mysqli_fetch_row($consulta_usuarios)) {
		echo "<option value='$row_usuarios[0]'>$row_usuarios[1]</option>";
  	}
  	$cadena = mysqli_query($conexion,"SELECT u.id, CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno)
										FROM agenda a
										INNER JOIN usuarios u ON u.id = a.id_usuario
										INNER JOIN personas p ON p.id = u.id_persona
										WHERE folio = '$folio'");
  	while ($row_seleccionadas = mysqli_fetch_array($cadena)) {
  		echo "<option value=\"$row_seleccionadas[0]\" selected>$row_seleccionadas[1]</option>";
  	}
?>