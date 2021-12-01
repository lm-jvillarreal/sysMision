<?php
// include'credenciales.php';
$db_host = "74.208.211.84";
$db_name = "sysadmision2";
$db_user = "mision";
$db_pass = "ABC1238f47";
$conexion=mysqli_connect($db_host,$db_user,$db_pass,$db_name);
if(mysqli_connect_errno()){
 printf(mysqli_connect_error());
}
mysqli_set_charset($conexion, 'utf8');
?>
