<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");
	
	$nombre            = $_POST['nombre'];
	$nombre            = trim($nombre);
	$descripcion       = $_POST['descripcion'];
	$descripcion       = trim($descripcion);
	$usuarios          = (isset($_POST['usuarios']))?$_POST['usuarios']:"";
	$cantidad_usuarios = (!empty($usuarios))?count($usuarios):0;
	$id_categoria      = $_POST['id_categoria'];
	
	if ($id_categoria == 0){

		if($nombre != "" && $descripcion != ""){
			$verificar = mysqli_query($conexion,"SELECT nombre FROM categoria_tareas WHERE nombre = '$nombre' AND activo = '1'");
			$cantidad  = mysqli_num_rows($verificar);

			if ($cantidad == 0){
				$consulta_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM categoria_tareas");
				$row_folio = mysqli_fetch_arraY($consulta_folio);
				$folio = $row_folio[0] + 1;

				$cadena = "INSERT INTO categoria_tareas (folio,nombre,descripcion,principal,fecha,hora,activo,id_usuario)
						VALUES ('$folio','$nombre','$descripcion','1','$fecha','$hora','1','$id_usuario')";
				$consulta = mysqli_query($conexion,$cadena);

				for ($i=0; $i < $cantidad_usuarios ; $i++) { 
					$cadena = "INSERT INTO categoria_tareas (folio,nombre,descripcion,principal,fecha,hora,activo,id_usuario)
						VALUES ('$folio','$nombre','$descripcion','0','$fecha','$hora','1','$usuarios[$i]')";
					$consulta = mysqli_query($conexion,$cadena);
				}
				echo "ok";
			}
			else{
				echo "duplicado";
			}
		}else{
			echo "vacio";
			exit;
		}
	}
	else{
		$actualizar = mysqli_query($conexion,"UPDATE categoria_tareas SET nombre = '$nombre', descripcion = '$descripcion', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE folio = '$id_categoria'");
		echo "ok";
	}
?>
