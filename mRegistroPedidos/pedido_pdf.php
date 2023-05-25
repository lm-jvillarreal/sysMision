<?php
include '../global_seguridad/verificar_sesion.php';
$folio_pedido=$_GET['flp'];
$cadenaFolio="SELECT 
                NOMBRE_CLIENTE, 
                TELEFONO_CLIENTE, 
                CONCAT(CALLE_CLIENTE,' ',NUMERO_CLIENTE,', ',COLONIA_CLIENTE), 
                DATE_FORMAT(HORA_FINALPEDIDO,'%H:%i:%s'), 
                (SELECT CONCAT(p.nombre,' ',p.ap_paterno) FROM personas as p INNER JOIN usuarios as u ON p.id=u.id_persona WHERE u.id=pv_pedidos.ID_TOMAPEDIDO),
                ID_SURTEPEDIDO
              FROM pv_pedidos 
                WHERE ID='$folio_pedido'";
$consultaPedido=mysqli_query($conexion,$cadenaFolio);
$rowPedido=mysqli_fetch_array($consultaPedido);
$date = date_create($fecha);
$format_fecha = date_format($date, 'd/m/Y');
require_once('../plugins/TCPDF-master/tcpdf.php');
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = '../plugins/TCPDF-master/logo.png';
        $this->Image($image_file, 10, 10, 170, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
$pdf->SetTitle('Pedidos a Domicilio');
$pdf->SetSubject('Detalle del pedido');
$pdf->SetKeywords('La Misión, Pedidos a Domicilio');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(5);

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
$pdf->SetFont('helvetica', 'B', 11);

// add a page
$pdf->AddPage();

// set some text to print
$html="
<br><br>
<h2 style='text-align:center;'>DETALLE DE PEDIDO</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html="
<table border=\"0\">
	<tr>
    <td align=\"left\">
      <h3>N°. Folio: $folio_pedido</h3>
    </td>
    <td align=\"right\">
      <h4>Sucursal: $nombre_sede</h4>
    </td>
	</tr>
	<tr>
		<td align=\"left\">
			<h4>Fecha: $format_fecha Hora: $rowPedido[3]</h4>
    </td>
	</tr>
</table>
<hr>
<table>
  <tr>
    <td width=\"75%\">Cliente: $rowPedido[0]</td>
    <td width=\"25%\">Tel: $rowPedido[1]</td>
  </tr>
  <tr>
    <td width=\"75%\">Dirección: $rowPedido[2]</td>
  </tr>
</table>
<hr>
";

$pdf->writeHTML($html, true, false, true, false, 'J');

$encabezado_tabla = "
<table border=\"1\" style=\"font-size: small;\">
	<tr>
		<th width=\"10%\">CANT.</th>
    <th width=\"50%\">DESCRIPCIÓN</th>
    <th width=\"40%\">COMENTARIOS</th>
    </tr>";
$cadenaDetalle="SELECT CANTIDAD, ARTC_DESCRIPCION FROM pv_renglonespedido WHERE ID_PEDIDO='$folio_pedido' ORDER BY ID DESC";
$consultaDetalle=mysqli_query($conexion,$cadenaDetalle);
$body_tabla="";
while($rowDetalle=mysqli_fetch_array($consultaDetalle)){
  $body_tabla=$body_tabla."<tr><td height=\"15\">$rowDetalle[0]</td><td height=\"15\" align=\"left\">&nbsp;$rowDetalle[1]</td><td></td></tr>";
}
$footer_tabla="	
</table>
";
$html = $encabezado_tabla.$body_tabla.$footer_tabla;
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "
<table border=\"0\" align=\"left\">
    <tr>
      <td width=\"50%\">
          Surtido Por: $rowPedido[5]
      </td>
      <td width=\"50%\" align=\"right\">
          Elaborado por: $rowPedido[4]
      </td>
    </tr>
</table>
";
$pdf->SetY(249);
$pdf->writeHTML($html, true, false, true, false, 'J');
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($folio_pedido.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>