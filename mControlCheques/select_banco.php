<?php
	include '../global_settings/conexion.php';
	   
	if(!isset($_POST['searchTerm'])){ 
		$cadena = "SELECT  banco, razon_social FROM catalogo_bancos WHERE activo = '1'";
	}else{ 
		$search = $_POST['searchTerm'];   
		$cadena = "SELECT banco, razon_social FROM catalogo_bancos WHERE activo = '1' AND banco LIKE '%$search%'";
	}
	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row = mysqli_fetch_array($consulta)) {
	 $data[] = array("text"=>$row[0], "id"=>$row[1], );
	}
	echo json_encode($data);
?>