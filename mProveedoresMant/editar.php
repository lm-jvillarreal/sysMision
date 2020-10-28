<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT
											nombre,
											razon_social,
											tel_empresa,
											nombre_vededor,
											cel_vendedor,
											corr_vend,
											nombre_supervisor,
											cel_supervisor,
											corr_superv
										FROM proveedores_mantenimiento 
										WHERE id_proveedor = '$id'");
    $row = mysqli_fetch_array($cadena);
    $array = array($row[0],
                    $row[1],
                    $row[2],
                    $row[3],
                    $row[4],
                    $row[5],
                    $row[6],
                    $row[7],
                    $row[8]);
	$array1 = json_encode($array);
	echo $array1;	
?>