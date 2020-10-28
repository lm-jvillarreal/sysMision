<?php
// Datos de conexion a la base de datos
$servidor='200.1.1.178';
$usuario='root';
$pass='Xoops1991';
$bd='sysadmision2';

// Nos conectamos a la base de datos
$conn_cal = new mysqli($servidor, $usuario, $pass, $bd);	

// Definimos que nuestros datos vengan en utf8
$conn_cal->set_charset('utf8');

// verificamos si hubo algun error y lo mostramos
if ($conn_cal->connect_errno) {
	echo "Error al conectar la base de datos {$conexion->connect_errno}";
}

// Url donde estara el proyecto, debe terminar con un "/" al final
$base_url="http://localhost/calendario_orden/";

?>
