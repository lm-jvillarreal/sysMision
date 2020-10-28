<?php
	include '../global_seguridad/verificar_sesion.php';

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_marcas = "SELECT id, (SELECT CONCAT(personas.nombre,' ', personas.ap_paterno,' ',personas.ap_materno) FROM personas WHERE personas.id = usuarios.id_persona) FROM usuarios WHERE activo = '1' AND id = '$id_usuario'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_marcas = "SELECT usuarios.id,CONCAT( personas.nombre, ' ', personas.ap_paterno, ' ', personas.ap_materno ) 
		FROM usuarios
		INNER JOIN personas ON personas.id = usuarios.id_persona 
		WHERE usuarios.activo = '1' AND personas.nombre like '%".$search."%'";
	} 


	$consulta_marcas = mysqli_query($conexion, $cadena_marcas);
	$data = array();
	$seleccionado = "";
	while ($row=mysqli_fetch_array($consulta_marcas)) {
		if($row[0] == $id_usuario){
			$seleccionado = "true";
		}else{
			$seleccionado = "";
		}
	 $data[] = array("id"=>$row[0], "text"=>$row[1], "selected"=>$seleccionado); 
	}

	echo json_encode($data);
?>