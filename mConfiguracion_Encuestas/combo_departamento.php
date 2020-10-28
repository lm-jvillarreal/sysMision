<?php
	include '../global_settings/conexion.php';
	if(!isset($_POST['searchTerm'])){ 
	  $cadena_departamentos = "SELECT id, nombre FROM departamentos WHERE activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_departamentos = "SELECT id, nombre FROM departamentos WHERE activo = '1' AND nombre like '%".$search."%'";
	} 


	$consulta_departamentos = mysqli_query($conexion, $cadena_departamentos);
	$data = array();
	while ($row_departamentos=mysqli_fetch_row($consulta_departamentos)) {
	  $data[] = array("id"=>$row_departamentos[0], "text"=>$row_departamentos[1]); 
	}
	echo json_encode($data);
?>
