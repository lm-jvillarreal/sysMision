<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");
	
	$valor = $_POST['valor'];
	$valor = trim($valor);
	$folio = $_POST['folio'];

	if($valor != "" && $folio != ""){
		$verificar = mysqli_query($conexion,"SELECT nombre FROM tareas WHERE nombre = '$valor' AND activo = '1' AND folio = '$folio'");
		$cantidad  = mysqli_num_rows($verificar);

		if ($cantidad == 0){
			$cadena = "INSERT INTO tareas (folio,nombre,fecha,hora,activo,id_usuario)
					VALUES ('$folio','$valor','$fecha','$hora','1','$id_usuario')";
			$consulta = mysqli_query($conexion,$cadena);
			echo "ok";
		}
		else{
			echo "duplicado";
		}
	}else{
		echo "vacio";
	}
?>
