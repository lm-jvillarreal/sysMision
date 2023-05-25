<?php
error_reporting(E_ALL ^ E_NOTICE);
    require_once('pdfEjemplo/conexion/conexion.php');
    //$id = $_GET['id'];  
    $sql = "SELECT
                ROCN_RENGLON,
                ARTC_ARTICULO,
                ROCN_CANTIDAD,
                ARTC_UNIMEDIDA,
                ROCN_DESCTO_ESPECIE,
                ROCC_DESCRIPCION,
                ROCN_PRECIO,
                ROCN_IMPORTE,
                ROCN_IVA,
                ROCN_IEPS
            FROM
                COM_RENGLONES_ORDENES_COMPRA
            WHERE
                ORDN_ORDEN = '$no_orden'";
    $st_renglones = oci_parse($conexion_central, $sql);
    oci_execute($st_renglones);
    //$datos=$mysqli->query($sql);
    $q = "SELECT
                ORDN_ORDEN,
                PROC_CVEPROVEEDOR,
                NOMBREALMACEN,
                ORDD_FECHA,
                NOMBREPROVEEDOR
            FROM
                COM_ORDENES_COMPRA_VW
            WHERE
                ORDN_ORDEN = '$no_orden'";
    $st = oci_parse($conexion_central, $q);
    oci_execute($st);
    $s = oci_fetch_row($st);
    // $suc=$mysqli->query($q);
    // $s=$suc->fetch_row();
    $sucursal = $s[2];
    $cve_prov = $s[1];
    $orden = $s[0];
    $fecha = $s[3];
    $n_prov = $s[4];

  date_default_timezone_set('America/Monterrey');
  $fecha = date('Y-m-d');
  $hora = date('H:i:s');
//============================================================+
// File name   : example_003.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
//               Custom Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('pdfEjemplo/tcpdf/tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        global $sucursal;
        global $cve_prov;
        global $fecha;
        global $orden;
        global $n_prov;
        // Logo
        //$image_file = K_PATH_IMAGES.'logo_example.jpg';
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('dejavusans', 25);
        // Title
        $this->Cell(0, 8, 'La Mision Supermercados. Orden de Compra # '.$orden, 0, true, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 5, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, true, 'R', 0, '', 0, false, 'T', 'M');
        //$this->Cell(0, 5, 'Prelistados para inventarios', 0, true, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 7, '# de Proveedor: '. $cve_prov, 0, true, 'L', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 7, 'Proveedor: '. $n_prov, 0, true, 'L', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 7, 'Almacen: '. $sucursal, 0, true, 'L', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 0, 'Fecha: '. $fecha, 0, true,'L', 0, '', 0, false, 'M', 'M');


    }

    // Page footer
    // public function Footer() {
        
    //     global $fecha;
    //     // Position at 15 mm from bottom
    //     $this->SetY(-50);
    //     // Set font
    //     $this->SetFont('helvetica', 8);
    //     $image_file = K_PATH_IMAGES.'footer.png';
    //     $this->Image($image_file, 10, 272, 190, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);      
    // }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Orden de compra');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(PDF_MARGIN_LEFT-10, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT-10);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM+10);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('courier', 'N', 9);

// add a page
$pdf->AddPage();

// set some text to print

$content = '';
    
    $content .= '
        <div class="row">
            <div class="col-md-12">
                <h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1>
        
      <table cellpadding="1" border="1">
        <thead>
          <tr>
            <th width="5%" align="center">#</th>
            <th width="15%" align="center">Articulo</th>
            <th width="5%" align="center">Cant</th>
            <th width="5%" align="left">UM</th>
            <th width="5%" align="center">Dcto.</th>
            <th width="33%" align="center">Descripcion</th>
            <th width="8%" align="center">Precio</th>
            <th width="8%">Importe</th>
            <th width="8%">Iva</th>
            <th width="8%">IEPS</th>
          </tr>
        </thead>
    ';
    
    
    while ($row_renglon = oci_fetch_row($st_renglones)) { 
            
    $content .= '
        <tr>
            <td width="5%" align="center">'.$row_renglon[0].'</td>
            <td width="15%" align="center">'.$row_renglon[1].'</td>
            <td width="5%" align="center">'.$row_renglon[2].'</td>
            <td width="5%" align="left">'.$row_renglon[3].'</td>
            <td width="5%" align="center">'.$row_renglon[4].'</td>
            <td width="33%" align="center">'.$row_renglon[5].'</td>
            <td width="8%" align="center">'.$row_renglon[6].'</td>
            <td width="8%" align="center">'.$row_renglon[7].'</td>
            <td width="8%" align="center">'.$row_renglon[8].'</td>
            <td width="8%" align="center">'.$row_renglon[9].'</td>
        </tr>
    ';
        }
    
    $content .= '</table>';
    
    
    $pdf->writeHTML($content, true, 0, true, 0);

    $pdf->lastPage();
    $pdf->output('orden_compra_pdf/OC - '.$orden.'.pdf', 'F');

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
$mail->SMTPDebug = 0;
//Set the hostname of the mail server
$mail->Host = 'mail.lamisionsuper.com';
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 587;
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
$mail->Username = '';
//Password to use for SMTP authentication
$mail->Password = '';
//Set who the message is to be sent from
$mail->setFrom($correo_persona, $nombre_persona);
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress('eugenio.rico@lamisionsuper.com', 'Eugenio Rico Cantu');
//Set the subject line
$mail->Subject = 'La Mision Supermercados | Orden de Compra No. '.$orden;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML(file_get_contents('content.php'), __DIR__);
//Replace the plain text body with one created manually
//$mail->AltBody = 'Estoy al pendiente de todos tus movimientos, puedo apropiarme de tu identidad';
//Attach an image file
$mail->addAttachment('orden_compra_pdf/OC - '.$orden.'.pdf');
//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'ok';
}
?>