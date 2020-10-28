<?php
include '../global_seguridad/verificar_sesion.php';

	if(!isset($_POST['id_checklist'])){ 
	  $filtro = "";
	}else{ 
	  $id_checklist = $_POST['id_checklist'];   
	  $filtro = " AND id_checklist = '$id_checklist'";
	} 

	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT id, nombre FROM detalle_checklist WHERE activo = '1' AND programada = '1'".$filtro;
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT id, nombre FROM detalle_checklist WHERE activo = '1' AND programada = '1' AND nombre like '%".$search."%'".$filtro;
	} 

	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_row($consulta)) {
	  $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}
	echo json_encode($data);
?>