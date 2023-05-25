<?php
	include '../global_seguridad/verificar_sesion.php';

  	if (isset($_POST['equipo'])) {
  		$equipo = $_POST['equipo'];
  		$filtro_equipo = " AND id_equipo = '$equipo'";
  	}

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_marcas = "SELECT id,marca FROM marcas WHERE activo = '1'and id_equipo = '3'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_marcas = "SELECT id,marca FROM marcas WHERE activo = '1'and id_equipo = '3'AND marca like '%".$search."%'";
	} 

	$consulta_marcas = mysqli_query($conexion, $cadena_marcas);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_marcas)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>