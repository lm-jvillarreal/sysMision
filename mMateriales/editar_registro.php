<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT
						                nombre,
                                        descripcion,
                                        id_bodega,
                                        (SELECT existencia FROM historial_existencia_materiales WHERE historial_existencia_materiales.codigo = catalago_materiales.codigo),
                                        proveedor
						              FROM
						                catalago_materiales
						              WHERE
						                activo = '1' 
						              AND id = '$id'");

	$row = mysqli_fetch_array($cadena);

	$array  = array(
                    $row[0], //Nombre
                    $row[1], //Descripcion
                    $row[2], //id_bodega
                    $row[3], //Existencia
                    $row[4]  //Proveedor
                );
	$array1 = json_encode($array);
	
	echo $array1;
	
?>