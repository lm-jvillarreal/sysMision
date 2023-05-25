<?php
	include '../global_seguridad/verificar_sesion.php';
	
	$filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";

	$id =$_POST['31'];
  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT id_caja, id_equipo from detalle_caja where activo = '1' and id_caja='$id'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT id_caja, id_equipo from detalle_caja where activo = '1' and id_caja='$id'";
	} 
	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>