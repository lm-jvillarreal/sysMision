<?php
$id_orden_compra = $_GET["id"];
$conexion=mysqli_connect("200.1.1.178","jvillarreal","Xoops1991","sysadmision2");
mysqli_set_charset($conexion, "utf8");
$cadena = "SELECT (SELECT nombre FROM proveedores_mantenimiento WHERE proveedores_mantenimiento.id_proveedor = ordenes_compra_mantenimiento.id_proveedor),
                folio,
                DATE_FORMAT(fecha, '%d-%m-%Y'),
                vendedor,
                telefono
            FROM ordenes_compra_mantenimiento
            WHERE id_orden_entrada = '$id_orden_compra'";
$consulta = mysqli_query($conexion, $cadena);
$row = mysqli_fetch_array($consulta);

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
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
$pdf->SetFont('helvetica', 'B', 12);

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
			<h3>Depto. Mantenimiento</h3>
		</td>
		<td align=\"right\">
			<h3>N°. Folio:$row[1]</h3>
		</td>
	</tr>
	<tr>
		<td align=\"left\">
			
		</td>
		<td align=\"right\">
			<h4>Fecha: $row[2]</h4>
		</td>
	</tr>
</table>
";

$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<hr>
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<h2>Detalle</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$encabezado_tabla = "
<table border=\"1\">
	<tr>
		<th width=\"13%\">Cantidad</th>
		<th width=\"61%\">Concepto</th>
		<th width=\"13%\">Costo</th>
		<th width=\"13%\">Importe</th>
	</tr>";

$cadena_detalle = "SELECT cantidad, concepto, costo, importe
                    FROM historial_ordenes
                    WHERE folio = '$id_orden_compra' AND activo = '1'";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$total_body = "";
$total = 0;
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
    $total += $row_detalle[3];
    $costo = money_format('%i', $row_detalle[2]);
    $importe = money_format('%i', $row_detalle[3]);
	$renglon = "
	<tr>
		<td>$row_detalle[0]</td>
		<td align=\"left\"> $row_detalle[1]</td>
        <td>$ $costo</td>
        <td>$ $importe</td>
	</tr>
	";
	$total_body = $total_body.$renglon;
}

$footer_tabla="	
</table>
";
$html = $encabezado_tabla.$total_body.$footer_tabla;
$pdf->writeHTML($html, true, false, true, false, 'C');

$total = money_format('%i', $total);
$iva = round($total * .16,2);
$iva = money_format('%i', $iva);
$total_iva = $total + $iva;
$total_iva = money_format('%i', $total_iva);
$html = "
<table border=\"0\" align=\"center\">
	<tr>
		<td>Sub-Total: $$total</td>
	</tr>
	<tr>
		<td>I.V.A: $$iva</td>
    </tr>
    <tr>
		<td>Total: $$total_iva</td>
	</tr>
</table>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "
<table border=\"0\" align=\"center\">
	<tr>
		<td>_______________________</td>
	</tr>
	<tr>
		<td>
			Solicita<br>
			Eugenio Rico
		</td>
	</tr>
</table>
";
$pdf->SetY(235);
$pdf->writeHTML($html, true, false, true, false, 'J');
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>