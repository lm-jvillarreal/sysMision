<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT
											id_sucursal_origen,
											(SELECT nombre FROM sucursales WHERE sucursales.id = traspasos.id_sucursal_origen),
											id_sucursal_destino,
											(SELECT nombre FROM sucursales WHERE sucursales.id = traspasos.id_sucursal_destino),
											codigo_interno,
											(SELECT descripcion FROM catalogo_piezas WHERE catalogo_piezas.codigo_interno = traspasos.codigo_interno),
											cantidad
										FROM traspasos 
										WHERE id = '$id'");
    $row = mysqli_fetch_array($cadena);
    $array = array($row[0],
                    $row[1],
                    $row[2],
					$row[3],
					$row[4],
					$row[5],
					$row[6]);
	$array1 = json_encode($array);
	echo $array1;	
?>