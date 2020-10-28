<?php
	include '../global_settings/conexion.php';

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT id, (SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) FROM personas WHERE personas.id = usuarios.id_persona)
	FROM usuarios WHERE id_perfil = '5' AND activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "	SELECT usuarios.id, CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno)
		FROM usuarios
		INNER JOIN personas ON personas.id = usuarios.id_persona
		WHERE usuarios.id_perfil = '5' AND usuarios.activo = '1'
		AND personas.nombre LIKE '%".$search."%'";
	} 

	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>