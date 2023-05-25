<?php
	include '../global_seguridad/verificar_sesion.php';
	// $equipo = $_POST['equipo'];
	// echo $equipo;

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT id,nombre FROM comentarios_errores WHERE activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT id,nombre FROM comentarios_errores WHERE activo = '1' AND nombre like '%".$search."%'";
	} 
	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
		$data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}
	echo json_encode($data);
?>