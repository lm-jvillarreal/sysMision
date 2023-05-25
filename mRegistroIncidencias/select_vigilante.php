<?php
	include '../global_seguridad/verificar_sesion.php';

  	if(isset($_POST['id'])){
		$id_persona = $_POST['id'];
	}
	else{
		$id = "";
	}

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_vigilante = "SELECT id, CONCAT(NOMBRE,' ',AP_PATERNO,' ',AP_MATERNO)
	  FROM vidvig_vigilantes WHERE activo = '1'and id_sucursal= '$id_sede'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_vigilante = "SELECT id, CONCAT(NOMBRE,' ',AP_PATERNO,' ',AP_MATERNO)
	  FROM vidvig_vigilantes WHERE activo = '1' ";
	} 


	$consulta_vigilante = mysqli_query($conexion, $cadena_vigilante);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_vigilante)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>
