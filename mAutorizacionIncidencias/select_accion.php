<?php
	include '../global_seguridad/verificar_sesion.php';

  	if(isset($_POST['id_registro'])){
		$id_persona = $_POST['id_registro'];
	}
	else{
		$id_registro = "";
	}

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_categoria = "SELECT id, nombre FROM sanciones_incidencias WHERE activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_categoria = "SELECT id, nombre FROM sanciones_incidencias WHERE activo = '1' ";
	} 


	$consulta_incidencia = mysqli_query($conexion, $cadena_categoria);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_incidencia)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1].' '.$row[2].' '.$row[3]); 
	}

	echo json_encode($data);
?>
