<?php
  	include '../global_seguridad/verificar_sesion.php';

	$id         = $_POST['id'];
	$comentario = "";
  	$cadena   = "SELECT (SELECT CONCAT(personas.nombre,' ', personas.ap_paterno,' ',personas.ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = bitacora_servicios.supervisor) FROM bitacora_servicios WHERE id = '$id'";
  	$consulta = mysqli_query($conexion, $cadena);
  	$row      = mysqli_fetch_array($consulta);

  	$comentario = ($row[0] == "")?"NO TIENE SuPERVISOR":$row[0].".";

  	echo $comentario;

 ?>