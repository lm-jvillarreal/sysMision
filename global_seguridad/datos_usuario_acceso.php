<?php 
	include '../global_settings/conexion.php';

	//Extraigo el ID de Usuario
	$id_usuario = $_SESSION["sysAdMision_id_usuario"];
	$id_persona = $_SESSION["sysAdMision_id_persona"];
	$perfil_usuario = $_SESSION["sysAdMision_perfil"];
	$nombre_perfil = $_SESSION["sysAdmision_nombre_perfil"];
	$nombre_persona = $_SESSION["sysAdMision_persona"];
	$fechaAlta_usuario = $_SESSION["sysAdMision_fechaAlta"];
	$id_sede = $_SESSION["sysAdMision_sede"];
	$correo_persona = $_SESSION["sysAdMision_correo"];
	$telefono_persona = $_SESSION["sysAdMision_telefono"];
	$nombre_sede = $_SESSION["sysAdmision_nombreSede"];

	$cadena_suc = "SELECT id, nombre FROM sucursales WHERE id='$id_sede'";
	$consulta_suc = mysqli_query($conexion,$cadena_suc);
	$row_suc = mysqli_fetch_array($consulta_suc);
	$nombre_sede = $row_suc[1];

	include 'obtener_carpeta.php';
	//Compruebo si tiene acceso al módulo en cuestión
	$cadena = "SELECT modulos.id, modulos.nombre,modulos.ayuda_modulo,modulos.ruta_manual 
				FROM modulos 
				INNER JOIN detalle_usuario
				ON modulos.id = detalle_usuario.id_modulo 
				AND detalle_usuario.id_usuario = '$id_usuario' 
				AND modulos.nombre_carpeta ='$nombre_modulo' 
				AND detalle_usuario.activo='1'";
				
	$consulta = mysqli_query($conexion, $cadena);
	$acceso_modulo =  mysqli_num_rows($consulta);

	$row_modulo = mysqli_fetch_array($consulta);

	$id_modulo     = (!empty($row_modulo[0]))?$row_modulo[0]:"";
	$nombre_modulo = (!empty($row_modulo[1]))?$row_modulo[1]:"";
	$ayuda_modulo  = (!empty($row_modulo[2]))?$row_modulo[2]:"";
	$manual        = (!empty($row_modulo[3]))?$row_modulo[3]:"";

	$dia_semana = date("l");

	if(file_exists('../d_plantilla/dist/img/personas/'.$id_usuario.'.jpg')){
		$imagen_persona = $id_usuario.'.jpg';
	}else{
		$imagen_persona = 'user.jpg';
	}

	
