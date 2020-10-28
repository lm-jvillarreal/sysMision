<?php
	include '../global_settings/conexion.php';

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_sucursales = "SELECT id,nombre FROM sucursales WHERE activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_sucursales = "SELECT id,nombre FROM sucursales WHERE activo = '1' AND nombre like '%".$search."%'";
	} 


	$consulta_sucursales = mysqli_query($conexion, $cadena_sucursales);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_sucursales)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>