<?php
include '../global_seguridad/verificar_sesion.php';

	if(!isset($_POST['searchTerm'])){ 
	  $cadena_usuarios = "SELECT
							(SELECT id FROM personas WHERE personas.id = usuarios.id_persona),
							(SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) FROM personas WHERE personas.id = usuarios.id_persona)
						FROM
							usuarios
						WHERE id_perfil = '5'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_usuarios = "SELECT personas.id,CONCAT(personas.nombre,' ', personas.ap_paterno,' ',personas.ap_materno) AS Nom FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE personas.activo = '1' AND usuarios.id_perfil = '5' AND personas.nombre like '%".$search."%'";
	} 

	$consulta_usuarios = mysqli_query($conexion, $cadena_usuarios);
	$data = array();
	while ($row_usuarios=mysqli_fetch_row($consulta_usuarios)) {
	  $data[] = array("id"=>$row_usuarios[0], "text"=>$row_usuarios[1]); 
	}
	echo json_encode($data);
?>