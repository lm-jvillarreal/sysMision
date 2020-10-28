<?php
// include'credenciales.php';
$db_host = "200.1.1.178";
$db_name = "sysadmision2";
$db_user = "jvillarreal";
$db_pass = "Xoops1991";
$conexion=mysqli_connect($db_host,$db_user,$db_pass,$db_name);
if(mysqli_connect_errno()){
 printf(mysqli_connect_error());
}
mysqli_set_charset($conexion, 'utf8');
?>
