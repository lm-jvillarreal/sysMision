<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

	$caja     = $_POST['caja'];
    $caja     = trim($caja);
	$sucursal = $_POST['sucursal_m'];
	$tipo_caja = $_POST['tipo_caja'];
	$id_registro_caja = $_POST['id_registro_caja'];

	if($caja != "" && $sucursal != ""){
		if($id_registro_caja == 0){
			$verificar = mysqli_query($conexion,"SELECT id FROM cajas WHERE nombre = '$caja' AND id_sucursal = '$sucursal' AND activo = '1'");
			$cantidad  = mysqli_num_rows($verificar);

			if ($cantidad == 0){
				$cadena = "INSERT INTO cajas (nombre,id_sucursal,id_tipo_caja,fecha,hora,activo,id_usuario)
						VALUES ('$caja','$sucursal','$tipo_caja','$fecha','$hora','1','$id_usuario')";
				$consulta = mysqli_query($conexion,$cadena);
				echo "ok";
			}else{
				echo "duplicado";
			}	
		}else{
			$cadena = mysqli_query($conexion,"UPDATE cajas SET nombre = '$caja', id_sucursal = '$sucursal', id_tipo_caja = '$tipo_caja', fecha = '$fecha', hora = '$hora' WHERE id = '$id_registro_caja'");
			echo "ok";
		}
	}else{
		echo "vacio";
	}
?>
