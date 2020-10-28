<?php
	include '../global_settings/conexion.php';

	$id_bodega = $_POST['id_bodega'];

	if($id_bodega != 0){
		$filtro = " AND NOT EXISTS (SELECT NULL FROM detalle_tbodega_usuarios WHERE detalle_tbodega_usuarios.usuario = usuarios.id AND detalle_tbodega_usuarios.id_bodega = '$id_bodega' AND detalle_tbodega_usuarios.activo= '1')";
	}else{
		$filtro = "";
	}

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT id, (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM personas WHERE personas.id = usuarios.id_persona) FROM usuarios WHERE activo = '1' ".$filtro;
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT usuarios.id, CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.activo = '1' AND CONCAT(nombre,' ',ap_paterno,' ',ap_materno) like '%".$search."%' ".$filtro;
	}

	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>