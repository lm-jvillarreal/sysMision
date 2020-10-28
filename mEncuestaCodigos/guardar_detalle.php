<?php
  	include '../global_seguridad/verificar_sesion.php';

	$codigo      = $_POST['codigo'];
	$id_registro = $_POST['id_registro'];

    $cadena_verificar = mysqli_query($conexion,"SELECT id FROM detalle_categoria_codigos WHERE codigo = '$codigo' AND id_categoria = '$id_registro'");
    $cantidad         = mysqli_num_rows($cadena_verificar);

   	if ($cantidad == 0){
    	$cadena = mysqli_query($conexion,"INSERT INTO detalle_categoria_codigos (id_categoria,codigo,fecha,hora,activo,id_usuario)VALUES ('$id_registro ','$codigo','$fecha','$hora','1','$id_usuario')");
      	echo "ok";
    }
    else{
      	echo "duplicado";
    }
?>