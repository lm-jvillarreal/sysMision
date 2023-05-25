<?php
	include '../global_seguridad/verificar_sesion.php';
	//SELECT id, CONCAT(nombre,' ',ap_paterno) FROM promotores WHERE activo='1'
 
	$categoria= $_POST['categoria'];

  	if(isset($_POST['id_incidencia'])){
		$id_persona = $_POST['id_incidencia'];
	}
	else{
		$id_incidencia = "";
	}

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_incidencia = "SELECT id, CONCAT(nombre,' ',ap_paterno) FROM promotores WHERE activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_incidencia = "SELECT id, CONCAT(nombre,' ',ap_paterno) FROM promotores WHERE CONCAT(nombre,' ',ap_paterno) LIKE '%$search%";
	} 


	$consulta_incidencia = mysqli_query($conexion, $cadena_incidencia);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_incidencia)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>
