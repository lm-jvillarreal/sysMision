<?php
include 'qrcode.php';
// QR_BarCode object 
$qr = new QR_BarCode(); 

// create contact QR code 
$qr->contact('Josué Villarreal', 'La Misión Supermercados', '8117598102', 'jvillarreal@lamisionsuper.com');

// display QR code image
$qr->qrCode();
?>

