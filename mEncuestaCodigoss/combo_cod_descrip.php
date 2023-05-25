<?php
	include '../global_seguridad/verificar_sesion.php';
	include '../global_settings/conexion_oracle.php';

	$id_examen = (isset($_POST['id_examen']))?$_POST['id_examen']:"";

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT codigo FROM detalle_examen WHERE id_examen = '$id_examen' AND activo = '1' ORDER BY RAND()";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT codigo FROM detalle_examen WHERE id_examen = '$id_examen' AND activo = '1' AND codigo LIKE '%".$search."%' ORDER BY RAND()";
	} 

	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
		
		$st = oci_parse($conexion_central,"SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$row[0]'");
	    oci_execute($st);
	    $row_producto = oci_fetch_row($st);
	    $cadena_completa = $row[0].' - '.$row_producto[0];

	 	$data[] = array("id"=>$row[0], "text"=>$cadena_completa); 
	}

	echo json_encode($data);
?>