<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

	$marca     = $_POST['marca_terminal'];
	$modelo    = $_POST['modelo_terminal'];
	$id_modelo = $_POST['id_modelo_modal'];
	$tipo          = (!empty($_POST['tipo_terminal']))?$_POST['tipo_terminal']:0;

	if ($id_modelo == 0){
		$verificar = mysqli_query($conexion,"SELECT modelo FROM modelos WHERE modelo = '$modelo' AND activo = '1'");
		$cantidad  = mysqli_num_rows($verificar);

		if ($cantidad == 0){
			$cadena = "INSERT INTO modelos (id_marca,modelo,tipo,fecha,hora,activo,id_usuario)
					VALUES ('$marca','$modelo','$tipo','$fecha','$hora','1','$id_usuario')";
			$consulta = mysqli_query($conexion,$cadena);
			echo "ok";
		}
		else{
			echo "duplicado";
		}
	}
	else{
		$actualizar = mysqli_query($conexion,"UPDATE modelos SET id_marca = '$marca', modelo = '$modelo', tipo = '$tipo', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_modelo'");
		echo "ok";
	}
?>
