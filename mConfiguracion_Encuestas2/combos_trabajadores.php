<?php
	include '../global_settings/conexion.php';


  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT codigo,nombre_completo FROM trabajadores_sql";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT codigo,nombre_completo FROM trabajadores_sql WHERE nombre_completo like '%".$search."%'";
	} 

	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>