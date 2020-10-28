<?php
  	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"SELECT nombre,
											id_sucursal,
											(SELECT nombre FROM sucursales WHERE sucursales.id = checklist.id_sucursal),
											id_departamento,
											(SELECT nombre FROM departamentos_checklist WHERE departamentos_checklist.id = checklist.id_departamento),
											id_categoria,
											tipo,
											id_perfil,
											(SELECT nombre FROM perfil WHERE perfil.id = checklist.id_perfil)
											FROM checklist WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena);

	$array = array( $row[0],
					$row[1],
					$row[2],
					$row[3],
					$row[4],
					$row[5],
					$row[6],
					$row[7],
					$row[8]);

	echo json_encode($array);
?>