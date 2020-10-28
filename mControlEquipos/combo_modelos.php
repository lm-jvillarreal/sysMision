<?php
	include '../global_seguridad/verificar_sesion.php';

	if(isset($_POST['marca'])){
		$marca = $_POST['marca'];
		$filtro_marca = " AND id_marca = '$marca'";
	}else{
		$filtro_marca = "";
	}

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_modelos = "SELECT id,modelo FROM modelos WHERE activo = '1'".$filtro_marca;
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_modelos = "SELECT id,modelo FROM modelos WHERE activo = '1'".$filtro_marca." AND modelo like '%".$search."%'";
	} 


	$consulta_modelos = mysqli_query($conexion, $cadena_modelos);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_modelos)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>