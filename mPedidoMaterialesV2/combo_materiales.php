<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_pedido = $_POST['id_pedido'];
	$filtro=(!empty($registros_propios) == '1')?"AND (detalle_tbodega_usuarios.usuario = '$id_usuario' OR detalle_tbodega_usuarios.usuario = '$perfil_usuario')":"";
  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT catalogo_materiales2.id,nombre 
				FROM catalogo_materiales2 
				INNER JOIN detalle_tbodega_usuarios ON detalle_tbodega_usuarios.id_bodega = catalogo_materiales2.id_tipo_bodega
				WHERE catalogo_materiales2.activo = '1' 
				AND detalle_tbodega_usuarios.activo = '1' ".$filtro."
				 AND NOT EXISTS (SELECT id 
                  FROM detalle_pedido
                  WHERE catalogo_materiales2.id = detalle_pedido.id_material AND detalle_pedido.id_pedido = '$id_pedido' AND activo = '1')";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT catalogo_materiales2.id,nombre 
				FROM catalogo_materiales2 
				INNER JOIN detalle_tbodega_usuarios ON detalle_tbodega_usuarios.id_bodega = catalogo_materiales2.id_tipo_bodega
				WHERE catalogo_materiales2.activo = '1' 
				AND detalle_tbodega_usuarios.activo = '1' ".$filtro."
				AND (detalle_tbodega_usuarios.usuario = '$id_usuario' OR detalle_tbodega_usuarios.usuario = '$perfil_usuario') AND NOT EXISTS (SELECT id 
                  FROM detalle_pedido
                  WHERE catalogo_materiales2.id = detalle_pedido.id_material AND detalle_pedido.id_pedido = '$id_pedido' AND activo = '1') AND nombre LIKE '%".$search."%'";
	} 
	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
		$data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}
	echo json_encode($data);
?>