<?php
	include '../global_seguridad/verificar_sesion.php';
 
	$categoria= $_POST['categoria'];

  	if(isset($_POST['id_incidencia'])){
		$id_persona = $_POST['id_incidencia'];
	}
	else{
		$id_incidencia = "";
	}

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_incidencia = "SELECT id_incidencia, nombre FROM catalogo_incidencias WHERE activo = '1' AND categoria = '$categoria'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_incidencia = "SELECT id_incidencia, nombre FROM catalogo_incidencias WHERE activo = '1' AND categoria = '$categoria'";
	} 


	$consulta_incidencia = mysqli_query($conexion, $cadena_incidencia);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_incidencia)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>
