<?php
	$mysqli=new mysqli("localhost","root","","supsys"); //servidor, usuario de base de datos, contraseña del usuario, nombre de base de datos
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
	$acentos = $mysqli->query("SET NAMES 'utf8'");

	$conexion_central = oci_connect("INFOFIN", "INFOFIN", "200.1.1.185/INFOFIN", 'AL32UTF8'); 
		 
		if (!$conexion_central) {    
		  $m = oci_error();    
		  echo $m['message'], "n";    
		  exit; 
		}
?>