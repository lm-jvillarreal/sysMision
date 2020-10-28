<?php
	include '../global_seguridad/verificar_sesion.php';

  	if(isset($_POST['id_persona'])){
		$id_persona = $_POST['id_persona'];
	}
	else{
		$id_persona = "";
	}

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_persona = "SELECT id, nombre, ap_paterno, ap_materno FROM personas WHERE activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_persona = "SELECT id, nombre, ap_paterno, ap_materno FROM personas WHERE activo = '1' ";
	} 


	$consulta_persona = mysqli_query($conexion, $cadena_persona);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_persona)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1].' '.$row[2].' '.$row[3]); 
	}

	echo json_encode($data);
?>
