<?php
	include '../global_seguridad/verificar_sesion.php';

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT id, nombre_rancho, CASE municipio WHEN '1' THEN 'Linares' WHEN '2' THEN 'Gral. Teran' ELSE 'Villagran' END AS municipio FROM ranchos WHERE activo = 1";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT id,nombre_rancho,CASE municipio WHEN '1' THEN 'Linares' WHEN '2' THEN 'Gral. Teran' ELSE 'Villagran' END AS municipio FROM ranchos WHERE activo = '1' AND nombre_rancho like '%".$search."%'";
	} 

	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>