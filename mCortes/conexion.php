<?php 
include '../../../inventario/configuracion/credenciales.php';
	$conexion = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db ($db_name, $conexion);
 ?>