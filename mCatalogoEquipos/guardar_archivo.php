<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$id_equipo=$_POST['id_equipoS'];

$f_nombre = $_FILES["archivosS"]['name'];
$f_tamano = $_FILES["archivosS"]['size']; 
$f_tipo = $_FILES["archivosS"]['type'];
$extension = end(explode(".", $_FILES['archivosS']['name']));

$name = $f_nombre.".".$extension;

if($f_nombre != ""){  
	$destino =  "archivos/".$name;
	if(copy($_FILES['archivosS']['tmp_name'],$destino)){

		$cadena_guardar = "INSERT INTO mtto_archivos (id_equipo, nombre_archivo, fecha, hora, activo, usuario)VALUES('$id_equipo', '$f_nombre', '$fecha', '$hora', '1', '$id_usuario')";

		echo $cadena_guardar;
		$guardar_imagen = mysqli_query($conexion, $cadena_guardar);
	    $status = "ok"; 
	}else{
	    $status = "invalido";
	} 
}
echo $status;
?>