<?php
	include '../global_seguridad/verificar_sesion.php';

  	if(isset($_POST['id_encuesta'])){
  		if(!empty($_POST['id_encuesta'])){
  			$id_encuesta = $_POST['id_encuesta'];
  		}else{
  			$id_encuesta = "";
  		}
  	}


  	if(!isset($_POST['searchTerm'])){ 
  		$cadena = "SELECT id,(SELECT CONCAT( personas.nombre, ' ', personas.ap_paterno, ' ', personas.ap_materno ) FROM personas WHERE personas.id = usuarios.id_persona) FROM usuarios WHERE NOT id IN (SELECT id_usuario_resp FROM s_invitados WHERE id_encuesta = '$id_encuesta') AND activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT usuarios.id, CONCAT( personas.nombre, ' ', personas.ap_paterno, ' ', personas.ap_materno ) 
		FROM usuarios
		INNER JOIN personas ON personas.id = usuarios.id_persona 
		WHERE NOT usuarios.id IN ( SELECT id_usuario_resp FROM s_invitados WHERE id_encuesta = '$id_encuesta' ) AND usuarios.activo = '1' AND (personas.nombre LIKE '%".$search."%' OR personas.ap_paterno LIKE '%".$search."%')";
	} 
	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>