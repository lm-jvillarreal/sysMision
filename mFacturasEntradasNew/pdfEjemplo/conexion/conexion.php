<?php
	$mysqli=new mysqli("200.1.1.178","root","Xoops1991","sysadmision_pruebas"); //servidor, usuario de base de datos, contraseña del usuario, nombre de base de datos
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
	$acentos = $mysqli->query("SET NAMES 'utf8'")
?>