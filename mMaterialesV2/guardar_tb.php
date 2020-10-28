<?php
	include '../global_seguridad/verificar_sesion.php';

	$nombretb            = $_POST['nombretb'];
	$tipotb              = $_POST['tipotb'];	
	$id_registrotb       = $_POST['id_registrotb'];
	$cantidad_encargados = 0;
	$cantidad_usuarios   = 0;

	if(isset($_POST['encargadotb'])){
		$encargadotb         = $_POST['encargadotb'];
		$cantidad_encargados = ($encargadotb != "")?count($encargadotb):"";
	}

	if($tipotb == 1){ // Perfil
		$usuarios = (isset($_POST['perfiltb']))?$_POST['perfiltb']:"";
	}else{ // Usuarios
		$usuarios = $_POST['usuariotb'];
	}

	if($usuarios != ""){
		$cantidad_usuarios = count($usuarios);
	}else{
		$cantidad_usuarios = 0;
	}

	if($id_registrotb == 0){
		$cadena = mysqli_query($conexion,"INSERT INTO tipo_bodega (nombre, fecha, hora, activo, id_usuario) VALUES ('$nombretb','$fecha','$hora','1','$id_usuario')");
		$cadena = mysqli_query($conexion,"SELECT MAX(id) FROM tipo_bodega");
		$row = mysqli_fetch_array($cadena);
		$id_tipo = $row[0];
		for ($i=0; $i < $cantidad_encargados; $i++) { 
			$cadena = mysqli_query($conexion,"INSERT INTO detalle_tbodega_encargados (id_bodega, encargado, fecha, hora, activo, id_usuario) VALUES ('$id_tipo','$encargadotb[$i]','$fecha','$hora','1','$id_usuario')");
		}
		if($tipotb == 1){
			$cadena = mysqli_query($conexion,"INSERT INTO detalle_tbodega_usuarios (id_bodega, tipo, usuario, fecha, hora, activo, id_usuario) VALUES ('$id_tipo','$tipotb','$usuarios','$fecha','$hora','1','$id_usuario')");
		}else{
			// for ($o=0; $o <= $cantidad_usuarios; $o++) { 
			// 	$cadena = mysqli_query($conexion,"INSERT INTO detalle_tbodega_usuarios (id_bodega, usuario, fecha, hora, activo, id_usuario) VALUES ('$id_tipo','$usuarios[$i]','$fecha','$hora','1','$id_usuario')");
			// }
		}

		echo "ok";

	}else{
		$cadena = mysqli_query($conexion,"UPDATE tipo_bodega SET nombre = '$nombretb' WHERE id = '$id_registrotb'");

		if($cantidad_encargados > 0){
			for ($i=0; $i < $cantidad_encargados; $i++) { 
				$cadena = mysqli_query($conexion,"INSERT INTO detalle_tbodega_encargados (id_bodega, encargado, fecha, hora, activo, id_usuario) VALUES ('$id_registrotb','$encargadotb[$i]','$fecha','$hora','1','$id_usuario')");
			}
		}

		if($cantidad_usuarios > 0){
			if($tipotb == 1){
				$cadena = mysqli_query($conexion,"INSERT INTO detalle_tbodega_usuarios (id_bodega, tipo, usuario, fecha, hora, activo, id_usuario) VALUES ('$id_registrotb','$tipotb','$usuarios','$fecha','$hora','1','$id_usuario')");
			}else{
				for ($i=0; $i <= $cantidad_usuarios; $i++) { 
					$cadena = mysqli_query($conexion,"INSERT INTO detalle_tbodega_usuarios (id_bodega, usuario, fecha, hora, activo, id_usuario) VALUES ('$id_registrotb','$usuarios[$i]','$fecha','$hora','1','$id_usuario')");
				}
			}
		}
		echo "act";
	}
?>