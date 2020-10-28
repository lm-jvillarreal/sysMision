<?php
	$mysqli=new mysqli("200.1.1.178","jvillarreal","Xoops1991","sysadmision2"); //servidor, usuario de base de datos, contraseña del usuario, nombre de base de datos
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
	$acentos = $mysqli->query("SET NAMES 'utf8'");

	$bd_host = "200.1.1.185/INFOFIN";
$bd_user = "INFOFIN";
$bd_pass = "INFOFIN";
$charset = "AL32UTF8";

//Se crea la cadena de conexión
$conexion_central = oci_connect($bd_user, $bd_pass, $bd_host, $charset); 


//Se evalúa que la conexión sea exitosa
if (!$conexion_central){    
  $m = oci_error();    
  echo $m['message'], "n";    
  exit; 
}
?>