<?php
	include '../global_settings/conexion.php';
	$dis = "";
	$cantidad = 0;

	$encuesta= $_POST['encuesta'];

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT codigo,nombre FROM sucursales_sql";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT codigo,nombre FROM sucursales_sql WHERE nombre like '%".$search."%'";
	} 

	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
		$cadena = mysqli_query($conexion,"SELECT n_resultados.id FROM n_resultados
					LEFT JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona WHERE n_resultados.folio_encuesta = '$encuesta' AND codigo_centro LIKE '$row[0]%'");
		
		$cantidad = mysqli_num_rows($cadena);
		if($cantidad == 0){
			$dis ="true";
		}else{
			$dis ="";
		}

		$data[] = array("id"=>$row[0], "text"=>$row[1], "disabled"=>$dis); 
	}

	echo json_encode($data);
?>