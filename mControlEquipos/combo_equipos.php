<?php
    include '../global_seguridad/verificar_sesion.php';

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_modelos = "SELECT id_tipo,nombre
                        FROM tipos_equipos 
                        WHERE activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_modelos = "SELECT id_tipo,nombre 
      FROM tipos_equipos 
      WHERE activo = '1' AND nombre like '%".$search."%'";
	} 
	$consulta_modelos = mysqli_query($conexion, $cadena_modelos);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_modelos)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>