<?php
  
  	include '../global_seguridad/verificar_sesion.php';

	$categoria   = $_POST['categoria'];
	$id_registro = $_POST['id_registro'];

	if($id_registro == 0){
	    $cadena_verificar = mysqli_query($conexion,"SELECT id FROM categoria_codigos WHERE nombre = '$categoria'");
	    $cantidad         = mysqli_num_rows($cadena_verificar);

	   	if ($cantidad == 0){
	    	$cadena = mysqli_query($conexion,"INSERT INTO categoria_codigos (nombre,fecha,hora,activo,id_usuario)
	              VALUES ('$categoria','$fecha','$hora','1','$id_usuario')");
	      	echo "ok";
	    }
	    else{
	      	echo "duplicado";
	    }
	}else{
	  	$cadena = mysqli_query($conexion,"UPDATE categoria_codigos SET nombre = '$categoria' WHERE id = '$id_registro'");
	   	echo "ok";
	}

?>