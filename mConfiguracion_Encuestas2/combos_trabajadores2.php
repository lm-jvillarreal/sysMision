<?php
	include '../global_settings/conexion.php';

	$suc      = $_POST['suc'];
	$depto    = $_POST['depto'];
	$encuesta = $_POST['encuesta'];

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT trabajadores_sql.codigo,trabajadores_sql.nombre_completo
				FROM n_resultados
				LEFT JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona WHERE trabajadores_sql.codigo_centro = '$suc$depto' AND folio_encuesta = '$encuesta' GROUP BY trabajadores_sql.codigo";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT trabajadores_sql.codigo,trabajadores_sql.nombre_completo FROM n_resultados LEFT JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona WHERE trabajadores_sql.codigo_centro = '$suc$depto' AND folio_encuesta = '$encuesta' AND trabajadores_sql.nombre_completo LIKE '%".$search."%' GROUP BY trabajadores_sql.codigo ";
	} 
	$datos = "true";

	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>