<?php
//ob_start();
include 'qrcode.php';
include '../global_seguridad/verificar_sesion.php';

// QR_BarCode object 
$qr = new QR_BarCode(); 

$cadenaEmpleado="SELECT CONCAT(nombre,' ',ap_paterno), e_mail, telefono FROM personas WHERE id = '$id_persona'";
$consultaEmpleado=mysqli_query($conexion,$cadenaEmpleado);
$row=mysqli_fetch_array($consultaEmpleado);

// create contact QR code 
$qr->contact($row[0], 'La Misión Supermercados', $row[2], $row[1]);

// display QR code image
$qr->qrCode();
//file_put_contents('src/qr_'.$id_persona.'.png', ob_get_contents());
?>

