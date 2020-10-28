<?php
	include '../global_seguridad/verificar_sesion.php';
	
	$filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena = "SELECT cajas.id,CONCAT(cajas.nombre,' ', sucursales.nombre) 
                        FROM cajas 
                        INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal
                        RIGHT JOIN detalle_caja ON detalle_caja.id_caja = cajas.id
                        WHERE cajas.activo = '1'".$filtro_sucursal." GROUP BY cajas.id";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena = "SELECT cajas.id,CONCAT(cajas.nombre,' ', sucursales.nombre) 
                            FROM cajas 
                            INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal
                            RIGHT JOIN detalle_caja ON detalle_caja.id_caja = cajas.id
                            WHERE cajas.activo = '1' ".$filtro_sucursal." AND (sucursales.nombre like '%".$search."%' OR cajas.nombre LIKE '%".$search."%') GROUP BY cajas.id";
	} 
	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>