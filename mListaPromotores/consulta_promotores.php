<?php
	include '../global_seguridad/verificar_sesion.php';
	// date_default_timezone_set('America/Monterrey');
	// $fecha=date("Y-m-d"); 
	// $hora=date ("H:i:s");


  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_sucursales = "SELECT id, CONCAT(promotores.nombre,' ',promotores.ap_paterno,' - ',promotores.compañia) AS Promotor FROM promotores
 					WHERE NOT EXISTS (SELECT NULL
                    FROM agenda_promotores
                    WHERE promotores.id = agenda_promotores.id_promotor
					AND dia = '$fecha' AND id_sucursal = '$id_sede')
					AND activo = '1'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_sucursales = "SELECT id, CONCAT(promotores.nombre,' ',promotores.ap_paterno,' - ',promotores.compañia) AS Promotor FROM promotores
 					WHERE NOT EXISTS (SELECT NULL
                    FROM agenda_promotores
                    WHERE promotores.id = agenda_promotores.id_promotor
					AND dia = '$fecha' AND id_sucursal = '$id_sede')
					AND activo = '1' AND CONCAT(promotores.nombre,' ',promotores.ap_paterno,' - ',promotores.compañia) like '%".$search."%'";
	} 
	$consulta_sucursales = mysqli_query($conexion, $cadena_sucursales);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_sucursales)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>