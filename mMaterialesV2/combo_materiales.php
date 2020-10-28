<?php
	include '../global_seguridad/verificar_sesion.php';

	$filtro=(!empty($registros_propios) == '1')?" AND detalle_tbodega_encargados.encargado = '$id_usuario'":"";

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT catalogo_materiales2.id, nombre 
		FROM catalogo_materiales2 
		INNER JOIN detalle_tbodega_encargados ON detalle_tbodega_encargados.id_bodega = catalogo_materiales2.id_tipo_bodega
		WHERE detalle_tbodega_encargados.activo = '1'
		AND catalogo_materiales2.activo = '1'".$filtro." GROUP BY catalogo_materiales2.id";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT catalogo_materiales2.id, nombre 
		FROM catalogo_materiales2 
		INNER JOIN detalle_tbodega_encargados ON detalle_tbodega_encargados.id_bodega = catalogo_materiales2.id_tipo_bodega
		WHERE detalle_tbodega_encargados.activo = '1'
		AND catalogo_materiales2.activo = '1' AND nombre LIKE '%".$search."%'".$filtro." GROUP BY catalogo_materiales2.id";
	} 
	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
		$data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}
	echo json_encode($data);
?>