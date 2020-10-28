<?php
error_reporting(E_ALL);
//Se declaran las variables de conexión
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
