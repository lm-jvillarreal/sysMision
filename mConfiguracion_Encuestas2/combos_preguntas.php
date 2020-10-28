<?php
	include '../global_settings/conexion.php';

	$encuesta = $_POST['encuesta'];


  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT id,pregunta FROM n_preguntas WHERE activo = '1' AND folio = '$encuesta'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT id,pregunta FROM n_preguntas WHERE activo = '1' AND folio = '$encuesta' AND pregunta like '%".$search."%'";
	} 

	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>