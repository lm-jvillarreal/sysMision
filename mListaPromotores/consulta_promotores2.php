<?php
	include '../global_seguridad/verificar_sesion.php';

	$fechaB = $_POST['fecha'];

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT promotores.id, CONCAT(nombre,' ',ap_paterno,' - ', compañia) FROM agenda_promotores
				LEFT JOIN promotores ON promotores.id = agenda_promotores.id_promotor 
				WHERE dia = '$fechaB' 
				AND id_sucursal = '$id_sede'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena= "SELECT promotores.id, CONCAT(nombre,' ',ap_paterno,' - ', compañia) FROM agenda_promotores
				LEFT JOIN promotores ON promotores.id = agenda_promotores.id_promotor 
				WHERE dia = '$fechaB' AND id_sucursal = '$id_sede' 
				AND CONCAT(promotores.nombre,' ',promotores.ap_paterno,' - ',promotores.compañia) like '%".$search."%'";
	} 
	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)){
		$cadena = mysqli_query($conexion,"SELECT id FROM registro_entrada WHERE id_promotor = '$row[0]' AND fecha = '$fechaB' AND id_sucursal = '$id_sede'");
		$existe = mysqli_num_rows($cadena);
		$disabled = ($existe != 0)?"":"true";
		$data[] = array("id"=>$row[0], "text"=>$row[1], "disabled" => $disabled); 
		$disabled = "";
	}

	echo json_encode($data);
?>