<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$marca         = $_POST['marca'];
	$modelo        = $_POST['modelo'];
	$numero_serie  = $_POST['numero_serie'];
	$numero_serie  = trim($numero_serie);
	$llave_banorte = $_POST['llave_banorte'];
	$llave_banorte = trim($llave_banorte);
	$caja          = $_POST['id_caja'];
	$afiliacion    = $_POST['afiliacion'];
	$afiliacion    = trim($afiliacion);
	$usuario       = $_POST['usuario_banorte'];
	$usuario       = trim($usuario);
	$contraseña    = $_POST['contraseña'];
	$contraseña    = trim($contraseña);
	$tipo          = $_POST['tipo'];
	$cashback      = $_POST['cashback'];
	$cifrada       = $_POST['cifrada'];
	$id_registro   = $_POST['id_registro'];

	if($marca !="" && $modelo !="" && $numero_serie != "" && $llave_banorte != "" && $caja != "" && $afiliacion != "" && $usuario != "" && $contraseña != "" && $tipo !="" && $cashback != "" && $cifrada != ""){
		if ($id_registro == 0){
			$verificar = mysqli_query($conexion,"SELECT id FROM control_equipos WHERE numero_serie = '$numero_serie' AND id_modelo = '$modelo' AND activo = '1'");
			$existe = mysqli_num_rows($verificar);
			if ($existe == 0){
				$cadena = "INSERT INTO control_equipos (id_marca,id_modelo,numero_serie,llave_banorte,id_caja,afiliacion,usuario,contrasena,tipo,cashback,cifrada,fecha,hora,id_usuario,activo)
				VALUES('$marca','$modelo','$numero_serie','$llave_banorte','$caja','$afiliacion','$usuario','$contraseña','$tipo','$cashback','$cifrada','$fecha','$hora','$id_usuario','1')";
				$consulta = mysqli_query($conexion,$cadena);
				echo "ok";
			}
			else{
				echo "duplicado";
			}
		}
		else{
			$actualizar  = mysqli_query($conexion,"UPDATE control_equipos SET id_marca = '$marca', id_modelo = '$modelo', numero_serie = '$numero_serie', llave_banorte = '$llave_banorte', id_caja = '$caja', afiliacion = '$afiliacion', usuario = '$usuario', contrasena = '$contraseña', tipo = '$tipo', cashback = '$cashback', cifrada = '$cifrada', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_registro'");
			echo "ok";
		}
	}else{
		echo "vacio";
	}

?>