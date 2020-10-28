<?php
    include '../global_seguridad/verificar_sesion.php';

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_modelos = "SELECT cajas.id,CONCAT(cajas.nombre,' ', sucursales.nombre) 
                        FROM cajas 
                        INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal
                        RIGHT JOIN detalle_caja ON detalle_caja.id_caja = cajas.id
                        WHERE cajas.activo = '1' AND detalle_caja.activo = '1' GROUP BY cajas.id";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_modelos = "SELECT cajas.id,CONCAT(cajas.nombre,' ', sucursales.nombre) 
                            FROM cajas 
                            INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal
                            RIGHT JOIN detalle_caja ON detalle_caja.id_caja = cajas.id
                            WHERE cajas.activo = '1' AND detalle_caja.activo = '1' AND (sucursales.nombre like '%".$search."%' OR cajas.nombre LIKE '%".$search."%') GROUP BY cajas.id";
	} 
	$consulta_modelos = mysqli_query($conexion, $cadena_modelos);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_modelos)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>