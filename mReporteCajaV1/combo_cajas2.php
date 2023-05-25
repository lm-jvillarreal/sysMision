<?php
    include '../global_seguridad/verificar_sesion.php';
    
    $id_sucursal = $_POST['id_sucursal'];

  	if(!isset($_POST['searchTerm'])){ 
	  $cadena_modelos = "SELECT cajas.id,CONCAT(cajas.nombre,' ', sucursales.nombre) 
                        FROM cajas 
                        INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal
                        WHERE cajas.activo = '1' AND cajas.id_sucursal = '$id_sucursal'";
	}else{ 
	  $search = $_POST['searchTerm'];   
	  $cadena_modelos = "SELECT cajas.id,CONCAT(cajas.nombre,' ', sucursales.nombre) 
                            FROM cajas 
                            INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal
                            WHERE cajas.activo = '1' AND cajas.id_sucursal = '$id_sucursal' AND (sucursales.nombre like '%".$search."%' OR cajas.nombre LIKE '%".$search."%')";
	} 

	$consulta_modelos = mysqli_query($conexion, $cadena_modelos);
	$data = array();
	while ($row=mysqli_fetch_array($consulta_modelos)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);
?>