<?php 
	//conexion central
		$conexion_central = oci_connect("INFOFIN", "INFOFIN", "200.1.1.185/INFOFIN", 'AL32UTF8'); 
		 
		if (!$conexion_central) {    
		  $m = oci_error();    
		  echo $m['message'], "n";    
		  exit; 
		}
	//credenciales
	$db_host = 'localhost';
	$db_user = 'root';
	$db_pass = '';
	$db_name = 'supsys';
	//conexion mysql
	$conexion=mysqli_connect($db_host,$db_user,$db_pass,$db_name) or die(mysqli_connect_errno());
   ?>