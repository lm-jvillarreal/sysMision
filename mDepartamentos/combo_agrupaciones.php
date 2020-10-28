<?php
	include '../global_settings/conexion.php';


	if(!isset($_POST['searchTerm'])){ 
	  $cadena_agrupaciones = "SELECT id,nombre FROM agrupaciones WHERE activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_agrupaciones = "SELECT id,nombre FROM agrupaciones WHERE activo = '1' AND nombre like '%".$search."%'";
	} 


	$consulta_agrupaciones = mysqli_query($conexion, $cadena_agrupaciones);
	$data = array();
	while ($row_agrupaciones=mysqli_fetch_row($consulta_agrupaciones)) {
	  $data[] = array("id"=>$row_agrupaciones[0], "text"=>$row_agrupaciones[1]); 
	}

	echo json_encode($data);
?>