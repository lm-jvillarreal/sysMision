<?php
include '../global_seguridad/verificar_sesion.php';

$cadena_validar = "SELECT MAX(id), nombre_solicita FROM formatos_movimientos WHERE tipo_movimiento = 'SXMPAN' AND activo = '1' AND sucursal = '$id_sede' group by id order by id desc limit 1";
$consulta_validar = mysqli_query($conexion, $cadena_validar);
$row_validar = mysqli_fetch_array($consulta_validar);

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
$pdf->SetTitle('Merma Panaderia');
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
$pdf->SetFont('helvetica', 'B', 12);

// add a page
$pdf->AddPage();

// set some text to print
$html="
<br><br>
<h2 style='text-align:center;'>MERMA PANADERÍA</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html="
<table border=\"0\">
	<tr>
		<td align=\"left\">
			<h3>N°. Folio: $row_validar[0]</h3>
        </td>
        <td align=\"right\">
			<h4>Sucursal: $nombre_sede</h4>
        </td>
	</tr>
	<tr>
		<td align=\"left\">
			<h4>Fecha: $format_fecha</h4>
        </td>
        <td align=\"right\">
            Folio InfoFin: ____________
        </td>
	</tr>
</table>
";

$pdf->writeHTML($html, true, false, true, false, 'J');

$encabezado_tabla = "
<table border=\"1\">
	<tr>
		<th width=\"20%\">CÓDIGO</th>
		<th width=\"10%\">CANT.</th>
        <th width=\"35%\">DESCRIPCIÓN</th>
        <th width=\"35%\">MOTIVO</th>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    <tr>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
        <td height=\"25\"></td>
    </tr>
    ";
$footer_tabla="	
</table>
";
$html = $encabezado_tabla.$footer_tabla;
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "
<table border=\"0\" align=\"center\">
    <tr>
        <td>
            $row_validar[1]
        </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
	<tr>
		<td>___________________</td>
		<td>___________________</td>
        <td>___________________</td>
        <td>___________________</td>
	</tr>
	<tr>
		<td>
			JEFE DEPTO.<br>
		</td>
		<td>
			VIGILANCIA<br>
		</td>
		<td>
			GERENCIA<br>
        </td>
        <td>
			SISTEMAS<br>
		</td>
    </tr>
    <tr>
        <td colspan=\"4\" align=\"right\">
            ESTE FORMATO NO ES VÁLIDO SI NO ESTÁ FIRMADO
        </td>
    </tr>
</table>
";
$pdf->SetY(220);
$pdf->writeHTML($html, true, false, true, false, 'J');
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('F_SXMPAN.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>