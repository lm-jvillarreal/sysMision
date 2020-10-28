<?php
	include '../global_seguridad/verificar_sesion.php';

  	if (!empty($_POST['monto'])) {
  		$monto = $_POST['monto'];
  		$filtro_monto = " AND detalle_control_gastos.monto = '$monto'";
  	}else{
  		$filtro_monto = "";
  	}

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT detalle_control_gastos.id,CONCAT(nombre_emisor,'- $',detalle_control_gastos.monto) FROM detalle_control_gastos LEFT JOIN gastos ON gastos.id_detalle_gasto = detalle_control_gastos.id WHERE detalle_control_gastos.activo = '1' AND ISNULL(id_detalle_gasto)".$filtro_monto;
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT detalle_control_gastos.id,CONCAT(nombre_emisor,'- $',detalle_control_gastos.monto) FROM detalle_control_gastos LEFT JOIN gastos ON gastos.id_detalle_gasto = detalle_control_gastos.id WHERE detalle_control_gastos.activo = '1' AND ISNULL(id_detalle_gasto)".$filtro_monto." AND detalle_control_gastos.nombre_emisor like '%".$search."%'";
	} 

	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>