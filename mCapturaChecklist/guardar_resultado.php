<?php
	include '../global_seguridad/verificar_sesion.php';
	$id         = $_POST['id'];
	$id         = trim($id, ',');
	$id         = explode(",",$id);

	$activos = $_POST['activo'];
	$activos = trim($activos, ',');
	$activos = explode(",",$activos);

	$resultados = $_POST['resultado'];
	$resultados    = trim($resultados, ',');
	$resultados = explode(",",$resultados);

	$checklist = $_POST['checklist'];
	$sucursal  = $_POST['sucursal'];
	$cant       = count($id);

	for ($i=0; $i < $cant; $i++) { 
		if($activos[$i] == 1){
			$cadena_v = mysqli_query($conexion,"SELECT id FROM resultados_checklist WHERE activo = '1' AND fecha = '$fecha' AND id_usuario = '$id_usuario' AND id_checklist = '$checklist'");
			$row_v = mysqli_fetch_array($cadena_v);
			if($row_v[0] == ""){
				$cadena_i = mysqli_query($conexion,"INSERT INTO resultados_checklist (id_checklist,id_sucursal,fecha,hora,activo,id_usuario) VALUES ('$checklist','$sucursal','$fecha','$hora','1','$id_usuario')");
				$cadena_s = mysqli_query($conexion,"SELECT MAX(id) FROM resultados_checklist");
				$row_s = mysqli_fetch_array($cadena_s);
				$id_resultados = $row_s[0];
			}else{
				$id_resultados = $row_v[0];
			}

			$cadena = mysqli_query($conexion,"INSERT INTO detalle_resultados_checklist (id_resultado,id_actividad,calificacion,fecha,hora,activo,id_usuario)
			VALUES ('$id_resultados','$id[$i]','$resultados[$i]','$fecha','$hora','1','$id_usuario')");
		}
	}
	echo "ok";
?>