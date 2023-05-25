<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_categoria = (isset($_POST['id_categoria']))?$_POST['id_categoria']:"";

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT id, codigo FROM detalle_categoria_codigos WHERE activo = '1' AND id_categoria = '$id_categoria'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT id, codigo FROM detalle_categoria_codigos WHERE activo = '1' AND id_categoria = '$id_categoria' AND codigo LIKE '%".$search."%'";
	} 

	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>