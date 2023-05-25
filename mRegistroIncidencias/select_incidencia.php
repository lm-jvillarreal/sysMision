<?php
	include '../global_seguridad/verificar_sesion.php';
 
	$tipo= $_POST['tipo'];

  	if(isset($_POST['id_incidencia'])){
		$id_persona = $_POST['id_incidencia'];
	}
	else{
		$id_incidencia = "";
	}

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_incidencia = "SELECT id,incidencia FROM catalogo_incidencias WHERE activo = '1' AND tipo = '$tipo'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_incidencia = "SELECT id,incidencia FROM catalogo_incidencias WHERE activo = '1' AND tipo = '$tipo'";
	} 


	$consulta_incidencia = mysqli_query($conexion, $cadena_incidencia);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_incidencia)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>
