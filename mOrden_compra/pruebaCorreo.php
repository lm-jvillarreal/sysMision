<?php
require '../plugins/PHPMailer-master/src/PHPMailer.php';
require '../plugins/PHPMailer-master/src/SMTP.php';
require '../plugins/PHPMailer-master/src/Exception.php';

include '../global_settings/conexion.php';

$cadenaDatos="SELECT CFG_USR, CFG_DMN, CFG_AUTH FROM CFG_COMPRAS";
$consultaAuth=mysqli_query($conexion,$cadenaDatos);
$rowAuth=mysqli_fetch_array($consultaAuth);

$cfg_usr=$rowAuth[0];
$cfg_dmn=$rowAuth[1];
$cfg_auth=$rowAuth[2];

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
$mail->Host = 'smtp.gmail.com';
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 465;
//Whether to use SMTP authentication
$mail->SMTPAuth = True;

$mail->SMTPSecure = True;

$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->CharSet = 'UTF-8';
//Username to use for SMTP authentication
$mail->Username = "sistemabt@utl.edu.mx";
//Password to use for SMTP authentication
$mail->Password = "ABC1238F47";
//Set who the message is to be sent from
$mail->setFrom('sistemabt@utl.edu.mx', 'sistemabt@utl.edu.mx');
//Set an alternative reply-to address
//$mail->addReplyTo($correo_persona, $nombre_persona);
//Set who the message is to be sent to
$mail->addAddress('gustavo.platas@tibs.com.mx', "Gustavo Platas");
//$mail->addCC($correo_persona);
//$mail->AddBCC ('aarizob@gmail.com');

//Set the subject line
$mail->Subject = 'Este es un correo de prueba';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$ruta = 'http://200.1.1.178/sysMision/mOrden_compra/1.png';
$mensaje = 'Hola';
$mail->msgHTML($mensaje);
//Replace the plain text body with one created manually
//$mail->AltBody = 'Estoy al pendiente de todos tus movimientos, puedo apropiarme de tu identidad';
//Attach an image file
//$mail->addAttachment('pdfEjemplo/firmas_correo/1.png');
//$mail->addAttachment('orden_compra_pdf/OC - '.$orden.'.pdf');
//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'ok';
}
//echo $cfg_usr.'@'.$cfg_dmn;
?>