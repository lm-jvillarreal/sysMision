<?php
require '../plugins/PHPMailer-master/src/PHPMailer.php';
require '../plugins/PHPMailer-master/src/SMTP.php';
require '../plugins/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Set the hostname of the mail server
$mail->Host = 'mail.lamisionsuper.com';
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 2525;
//Whether to use SMTP authentication
$mail->SMTPAuth = True;

$mail->SMTPSecure = False;

$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->CharSet = 'UTF-8';
//Username to use for SMTP authentication
$mail->Username = 'jvillarreal@lamisionsuper.com';
//Password to use for SMTP authentication
$mail->Password = 'GEX356qQ!';
//Set who the message is to be sent from
$mail->setFrom('jvillarreal@lamisionsuper.com', 'jvillarreal@lamisionsuper.com');
//Set an alternative reply-to address
//$mail->addReplyTo($correo_persona, $nombre_persona);
//Set who the message is to be sent to
//$mail->addAddress($row_proveedor[0], $row_proveedor[1]);
//$mail->addCC($correo_persona);
$mail->AddBCC ('jvillarreal@lamisionsuper.com');

//Set the subject line
$mail->Subject = 'La Mision Supermercados '.$sucursal.' | OC-. '.$orden;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$ruta = 'http://200.1.1.178/sysMision/mOrden_compra/1.png';
$mensaje = 'Envío Orden de Compra Folio <strong>'.$orden.'</strong> para la sucursal <strong>'.$sucursal.'</strong>.
            <br>Favor de respetar las cantidades y precios pactados en esta orden de compra.
            <br>Se solicita su apoyo para realizar una factura por cada orden de compra recibida.
            <br>Favor de confirmar de recibido.';
$mail->msgHTML($mensaje);
//Replace the plain text body with one created manually
//$mail->AltBody = 'Estoy al pendiente de todos tus movimientos, puedo apropiarme de tu identidad';
//Attach an image file
//$mail->addAttachment('pdfEjemplo/firmas_correo/1.png');
$mail->addAttachment('orden_compra_pdf/OC - '.$orden.'.pdf');
//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'ok';
}
?>