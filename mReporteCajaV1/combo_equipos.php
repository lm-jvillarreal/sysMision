<?php
	include '../global_settings/conexion.php';

	$id_caja = (isset($_POST['id_caja']))?$_POST['id_caja']:"";

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT cajas_catalogo_equipos.id, CONCAT(cajas_catalogo_equipos.nombre,' - ', cajas_catalogo_equipos.descripcion) 
	  				FROM detalle_caja 
	  				INNER JOIN cajas_catalogo_equipos ON cajas_catalogo_equipos.id = detalle_caja.id_equipo WHERE id_caja = '$id_caja' AND detalle_caja.activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT cajas_catalogo_equipos.id, CONCAT(cajas_catalogo_equipos.nombre,' - ', cajas_catalogo_equipos.descripcion) 
					FROM detalle_caja 
					INNER JOIN cajas_catalogo_equipos ON cajas_catalogo_equipos.id = detalle_caja.id_equipo WHERE id_caja = '$id_caja' AND detalle_caja.activo = '1' AND CONCAT(cajas_catalogo_equipos.nombre,' - ', cajas_catalogo_equipos.descripcion) like '%".$search."%'";
	} 
	// echo $cadena;
	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>