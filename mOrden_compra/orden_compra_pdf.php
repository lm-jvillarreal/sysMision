<?php
error_reporting(E_ALL ^ E_NOTICE);
$importe = 0;
$iva     = 0;
$ieps    = 0;
include '../global_settings/conexion_oracle.php';

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
                ROCN_IEPS,
                TO_CHAR(ROCD_ESTENTREGA, 'YYYY-MM-DD'),
                ROCN_PRECIO_NEGFINAL
            FROM
                COM_RENGLONES_ORDENES_COMPRA
            WHERE
                ORDN_ORDEN = '$no_orden' AND (ROCN_MODIFICACION) IS NULL";
    $st_renglones = oci_parse($conexion_central, $sql);
    oci_execute($st_renglones);
    //$st_fechaLlega = oci_fetch_row($st_renglones);
    //$datos=$mysqli->query($sql);
    $q = "SELECT
                ORDN_ORDEN,
                PROC_CVEPROVEEDOR,
                NOMBREALMACEN,
                ORDD_FECHA,
                NOMBREPROVEEDOR,
                ORDC_CONDPAGO,
                NOMBREUSUARIO
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
    $fecha = $fecha_llegada;
    $n_prov = $s[4];
    $cond_pago = $s[5];
    $comprador = $s[6];

  date_default_timezone_set('America/Monterrey');
  $fecha_hoy = date('Y-m-d');
  $hora = date('H:i:s');

require_once('../plugins/TCPDF-master/tcpdf.php');
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = 'logo.png';
        $this->Image($image_file, 10, 10, 150, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        //$this->SetFont('helvetica', 'B', 18);
        // Title
        //$this->Cell(0, 15, 'LA MISIÓN SUPERMERCADOS S.A. DE C.V.Hola', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Josué Villarreal');
$pdf->SetTitle('Carta Faltante');
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
$pdf->SetMargins(PDF_MARGIN_LEFT-10, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT-10);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// set font
$pdf->SetFont('helvetica', 'N', 9);

// add a page
$pdf->AddPage();

// set some text to print
$html="
<br><br>
<h2 style='text-align:center;'>ORDEN DE COMPRA</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html="
<table border=\"0\">
	<tr>
		<td align=\"left\">
			<h4>Proveedor:<br> $cve_prov - ".ltrim($n_prov)."</h4>
		</td>
		<td align=\"right\">
			<h3>N°. Folio: $orden</h3>
		</td>
	</tr>
	<tr>
		<td align=\"left\">
			<h4>Lugar de Entrega: $sucursal</h4>
		</td>
		<td align=\"right\">
			<h4>Fecha de entrega: $fecha</h4>
		</td>
	</tr>
	<tr>
		<td>
			<h4>Condición Pago: $cond_pago DIAS</h4>
		</td>
	</tr>
</table>
";

$pdf->writeHTML($html, true, false, true, false, 'J');


$encabezado_tabla = "
<table border=\"1\">
	<tr>
	    <th width=\"5%\" align=\"center\">#</th>
	    <th width=\"10%\" align=\"center\">Artículo</th>
        <th width=\"6%\" align=\"center\">C.P.</th>
	    <th width=\"5%\" align=\"center\">Cant.</th>
	    <th width=\"8%\" align=\"center\">UM</th>
	    <th width=\"38%\" align=\"center\">Descripción</th>
	    <th width=\"8%\" align=\"center\">Precio</th>
	    <th width=\"8%\">Importe</th>
	    <th width=\"6%\">IVA</th>
	    <th width=\"6%\">IEPS</th>
	  </tr>";

$total_body = "";
while ($row_renglon = oci_fetch_row($st_renglones)) {
    $CcveProd = "SELECT PROC_CLAVE FROM INV_CLAVEPROVEEDOR WHERE artc_articulo = '$row_renglon[1]' AND PROC_PROVEEDOR = '$cve_prov'";
    $stCcvePrd = oci_parse($conexion_central, $CcveProd);
    oci_execute($stCcvePrd);
    $sCveprod = oci_fetch_row($stCcvePrd);
    $ClaveProveedor = $sCveprod[0];

    if(is_null($row_renglon[11])){
        $costo=$row_renglon[6];
    }else{
        $costo=$row_renglon[11];
    }
    $total_body .= '
        <tr>
            <td width="5%" align="center">'.$row_renglon[0].'</td>
            <td width="10%" align="center">'.$row_renglon[1].'</td>
            <td width="6%" align="center">'.$ClaveProveedor.'</td>
            <td width="5%" align="center">'.$row_renglon[2].'</td>
            <td width="8%" align="center">'.$row_renglon[3].'</td>
            <td width="38%" align="center">'.$row_renglon[5].'</td>
            <td width="8%" align="center">'.$costo.'</td>
            <td width="8%" align="center">'.$row_renglon[7].'</td>
            <td width="6%" align="center">'.$row_renglon[8].'</td>
            <td width="6%" align="center">'.$row_renglon[9].'</td>
        </tr>
    ';
    $importe = $importe+$row_renglon[7];
    $iva = $iva + $row_renglon[8];
    $ieps = $ieps + $row_renglon[9];
}

$footer_tabla="	
</table>
";
$html = $encabezado_tabla.$total_body.$footer_tabla;
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "
<table border=\"0\" align=\"right\">
	<tr>
		<td>Subtotal</td>
		<td>".money_format("%.2n", $importe)."</td>
	</tr>
	<tr>
		<td>IVA</td>
		<td>".money_format("%.2n", $iva)."</td>
	</tr>
	<tr>
		<td>IEPS</td>
		<td>".money_format("%.2n", $ieps)."</td>
	</tr>
	<tr>
		<td>Total</td>
		<td>".money_format("%.2n", $importe+$iva+$ieps)."</td>
	</tr>
</table>
";
$pdf->SetX(150);
$pdf->writeHTML($html, true, false, true, false, 'J');

$html = "<p>EN TÉRMINOS DE PAGO, SE RESPETARÁN LOS PRECIOS PACTADOS EN LA ORDEN DE COMPRA. UNA VEZ ENTREGADA LA MERCANCÍA, NO SE ACEPTAN MODIFICACIONES DE PRECIOS.<br>SE SOLICITA REALIZAR UNA FACTURA POR CADA ORDEN DE COMPRA RECIBIDA.</p>";

$pdf->writeHTML($html, true, false, true, false, 'J');

$html = "
$comprador
<BR>
COMPRADOR
";
$pdf->SetY(245);
$pdf->writeHTML($html, true, false, true, false, 'C');
// ---------------------------------------------------------

//Close and output PDF document
$pdf->lastPage();
$pdf->output('orden_compra_pdf/OC - '.$orden.'.pdf', 'F');

//============================================================+
// END OF FILE
//============================================================+

include '../global_settings/conexion.php';

$cadenaDatos="SELECT CFG_USR, CFG_DMN, CFG_AUTH FROM CFG_COMPRAS";
$consultaAuth=mysqli_query($conexion,$cadenaDatos);
$rowAuth=mysqli_fetch_array($consultaAuth);

$cfg_usr=$rowAuth[0];
$cfg_dmn=$rowAuth[1];
$cfg_auth=$rowAuth[2];

$cadena_proveedor = "SELECT correo_vendedor, proveedor FROM proveedores WHERE numero_proveedor = '$cve_prov'";
$consulta_proveedor = mysqli_query($conexion, $cadena_proveedor);
$row_proveedor = mysqli_fetch_array($consulta_proveedor);
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
$mail->Username = $cfg_usr.'@'.$cfg_dmn;
//Password to use for SMTP authentication
$mail->Password = $cfg_auth;
//Set who the message is to be sent from
$mail->setFrom($correo_persona, $nombre_persona);
//Set an alternative reply-to address
//$mail->addReplyTo($correo_persona, $nombre_persona);
//Set who the message is to be sent to
$mail->addAddress($row_proveedor[0], $row_proveedor[1]);
$mail->addCC($correo_persona);
//$mail->AddBCC ('jvillarreal@lamisionsuper.com');

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