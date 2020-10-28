<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

	$nombre_marca = $_POST['marca_r'];
	$id_marca     = $_POST['id_marca_modal'];
	$equipo_marca = $_POST['equipo_marca'];
	$nombre_marca = trim($nombre_marca);

	if($nombre_marca != ""){
		if($id_marca == 0){
			$verificar = mysqli_query($conexion,"SELECT marca FROM marcas WHERE marca = '$nombre_marca' AND activo = '1' AND id_equipo = '$equipo_marca'");
			$cantidad  = mysqli_num_rows($verificar);

			if ($cantidad == 0){
				$cadena = "INSERT INTO marcas (marca,id_equipo,fecha,hora,activo,id_usuario)
						VALUES ('$nombre_marca','$equipo_marca','$fecha','$hora','1','$id_usuario')";
				$consulta = mysqli_query($conexion,$cadena);
				echo "ok";
			}else{
				echo "duplicado";
			}
		}else{
			$cadena_act = "UPDATE marcas SET marca = '$nombre_marca', id_equipo = '$equipo_marca',fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_marca'";
			$consulta = mysqli_query($conexion,$cadena_act);
			echo "ok";
		}
	}else{
		echo "vacio";
	}
?>
