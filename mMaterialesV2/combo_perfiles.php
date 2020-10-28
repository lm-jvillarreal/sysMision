<?php
	include '../global_settings/conexion.php';

	$id_bodega = $_POST['id_bodega'];

	$cadena = mysqli_query($conexion,"SELECT tipo FROM detalle_tbodega_usuarios WHERE id_bodega = '$id_bodega'");
	$row    = mysqli_fetch_array($cadena);

	if($row[0] == 1){
		$filtro = ($id_bodega != 0)?" AND NOT EXISTS (SELECT NULL FROM detalle_tbodega_usuarios WHERE detalle_tbodega_usuarios.usuario = perfil.id AND detalle_tbodega_usuarios.id_bodega = '$id_bodega' AND detalle_tbodega_usuarios.activo = '1')":"";
	}else{
		$filtro = "";
	}

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT id,nombre FROM perfil WHERE activo = '1'".$filtro;
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT id, nombre FROM perfil WHERE activo = '1' AND nombre LIKE '%".$search."%'".$filtro;
	} 

	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>