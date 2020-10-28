<?php
	include '../global_seguridad/verificar_sesion.php';

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_personas = "SELECT id,( SELECT CONCAT( nombre,' ',ap_paterno,' ',ap_materno) AS Nom
								FROM personas
								WHERE personas.id = usuarios.id_persona)
						FROM usuarios
						WHERE activo = '1'
						AND id_perfil = '11' OR (id_persona = '19' OR id_persona= '41' OR id_persona = '3' OR id_persona = '1')";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_personas = "SELECT usuarios.id, CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) AS Nomb
						FROM usuarios
						INNER JOIN personas ON personas.id = usuarios.id_persona
						WHERE usuarios.activo = '1'
						AND personas.nombre LIKE '%".$search."%'";
	} 

	$consulta_personas = mysqli_query($conexion, $cadena_personas);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_personas)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>