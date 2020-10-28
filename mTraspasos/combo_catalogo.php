<?php
    include '../global_seguridad/verificar_sesion.php';
    
    $id_sucursal=(isset($_POST['id_sucursal']))?$_POST['id_sucursal']:"";

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT codigo_interno, descripcion FROM catalogo_piezas WHERE activo = '1' AND id_sucursal = '$id_sucursal'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT codigo_interno, descripcion FROM catalogo_piezas WHERE activo = '1' AND id_sucursal = '$id_sucursal' AND descripcion like '%".$search."%'";
    } 
	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row =mysqli_fetch_array($consulta)) {
	    $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>