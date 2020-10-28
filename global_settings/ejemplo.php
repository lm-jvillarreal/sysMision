<?php
//Set de zona horaria
date_default_timezone_set("America/Monterrey");
$fecha = date("Y-m-d");
$hora = date("H:i:s");

//variables para conexion
$db_host = "200.1.1.178";
$db_name = "admision2";
$db_user = "root";
$db_pass = "XssHjmniTT09xnj!";

//cadena de conexion
$conexion=mysqli_connect($db_host,$db_user,$db_pass,$db_name);
if(mysqli_connect_errno()){
 printf(mysqli_connect_error());
}
//Set charset a cadena de conexion
mysqli_set_charset($conexion, 'utf8');

//Cadena para insertar
$cadena = "INSERT INTO personas (nombre, ap_paterno, ap_materno, fecha, hora)VALUES('Josue','Villarreal','Alvarado','$fecha','$hora')";
$insertar = mysqli_query($conexion, $cadena);

//Cadena para consulta
$cadena = "SELECT * FROM personas";
$consultar = mysqli_query($conexion, $cadena);
$row = mysqli_fetch_array($consultar);
?>
