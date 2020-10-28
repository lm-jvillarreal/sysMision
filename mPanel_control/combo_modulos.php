<?php
	include '../global_seguridad/verificar_sesion.php';

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_sucursales = "SELECT modulos.id, modulos.nombre 
	  						FROM detalle_usuario 
	  						INNER JOIN modulos ON modulos.id = detalle_usuario.id_modulo
							WHERE detalle_usuario.id_usuario = '$id_usuario' AND modulos.activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_sucursales = "SELECT modulos.id, modulos.nombre 
	  						FROM detalle_usuario 
	  						INNER JOIN modulos ON modulos.id = detalle_usuario.id_modulo
							WHERE detalle_usuario.id_usuario = '$id_usuario' AND modulos.activo = '1' AND modulos.nombre like '%".$search."%'";
	} 


	$consulta_sucursales = mysqli_query($conexion, $cadena_sucursales);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_sucursales)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>