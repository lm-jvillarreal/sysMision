<?php
include '../global_settings/conexion_oracle.php';
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');	

$codigo = $_POST['codigo'];
$cadenaArtc="";
$stArtc=oci_parse($conexion_central,$cadenaArtc);
oci_execute($stArtc);
$rowArtc = oci_fetch_row($stArtc);


?>