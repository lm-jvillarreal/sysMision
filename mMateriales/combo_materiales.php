<?php
	include '../global_seguridad/verificar_sesion.php';

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_materiales = "SELECT
	  						id,
							(
								SELECT nombre
								FROM catalago_materiales
								WHERE catalago_materiales.codigo = historial_existencia_materiales.codigo
							),
							existencia
						FROM historial_existencia_materiales
						WHERE activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_materiales = "SELECT cm.id, cm.nombre, he.existencia
							FROM historial_existencia_materiales he
							INNER JOIN catalago_materiales cm ON cm.codigo = he.codigo
							WHERE he.activo = '1'
							AND cm.nombre LIKE '%".$search."%'";
	} 
	$consulta_materiales = mysqli_query($conexion, $cadena_materiales);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_materiales)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}
	echo json_encode($data);
?>