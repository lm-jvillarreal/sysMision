<?php
$id_orden_compra = $_GET["id"];
$conexion=mysqli_connect("200.1.1.178","jvillarreal","Xoops1991","sysadmision2");
mysqli_set_charset($conexion, "utf8");
$cadena_consulta = "SELECT id, id_orden, no_orden, tipo_orden, no_factura, id_sucursal, DATE_FORMAT(fecha_elaboracion, '%d/%m/%Y'), total_diferencia, transportista, total_diferencia, bodeguero, numero_proveedor FROM carta_faltante WHERE id='$id_orden_compra'";
$ejecuta_consulta = mysqli_query($conexion, $cadena_consulta);
$row_orden_compra = mysqli_fetch_array($ejecuta_consulta);

$cadena_id_proveedor = "SELECT id_proveedor FROM orden_compra WHERE id = '$row_orden_compra[1]'";
$consulta_id_proveedor = mysqli_query($conexion, $cadena_id_proveedor);
$row_id_proveedor = mysqli_fetch_array($consulta_id_proveedor);

$cadena_proveedor = "SELECT proveedor FROM proveedores WHERE numero_proveedor = '$row_id_proveedor[0]'";
$consulta_proveedor = mysqli_query($conexion, $cadena_proveedor);
$row_proveedor = mysqli_fetch_array($consulta_proveedor);

$cadena_nota = "SELECT numero_nota FROM libro_diario WHERE orden_compra = $row_orden_compra[1]";
$consulta_nota = mysqli_query($conexion, $cadena_nota);
$row_nota = mysqli_fetch_array($consulta_nota);

$cadena_sucursal = "SELECT nombre FROM sucursales WHERE id = '$row_orden_compra[5]'";
$consulta_sucursal = mysqli_query($conexion, $cadena_sucursal);
$row_sucursal = mysqli_fetch_array($consulta_sucursal);

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
<h2 style='text-align:center;'>CARTA FALTANTE - SOBRANTE</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html="
<table border=\"0\">
	<tr>
		<td align=\"left\">
			<h3>Sucursal $row_sucursal[0]</h3>
		</td>
		<td align=\"right\">
			<h3>N°. Folio:$row_orden_compra[0]</h3>
		</td>
	</tr>
	<tr>
		<td align=\"left\">
			<h4>Copia para transportista</h4>
		</td>
		<td align=\"right\">
			<h4>Fecha: $row_orden_compra[6]</h4>
		</td>
	</tr>
</table>
";

$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<hr>
<p>Estimado Proveedor: $row_proveedor[0]<br>Le comunicamos que con la remesa recibida, cuyos datos abajo detallamos determinamos el siguiente:
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<h2>$row_orden_compra[3]</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "
<p>Para cualquier aclaración, favor de citar nuestro Folio de Entrada No: $row_nota[0]</p>
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$html = "
<table border=\"0\">
	<tr>
		<td>
			De fecha: $row_orden_compra[6]
		</td>
		<td align=\"right\">
			Su Factura: $row_orden_compra[4] 
		</td>
	</tr>
</table>
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$encabezado_tabla = "
<table border=\"1\">
	<tr>
		<th width=\"20%\">Cantidad</th>
		<th width=\"60%\">Descripción</th>
		<th width=\"20%\">U. M.</th>
	</tr>";

$cadena_detalle = "SELECT cantidad_producto, descripcion, unidad_medida, costo_unitario, total_renglon FROM detalle_carta_faltante WHERE id_carta_faltante = '$row_orden_compra[0]'";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$total_body = "";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
	$renglon = "
	<tr>
		<td>$row_detalle[0]</td>
		<td align=\"left\"> $row_detalle[1]</td>
		<td>$row_detalle[2]</td>
	</tr>
	";
	$total_body = $total_body.$renglon;
}

$footer_tabla="	
</table>
";
$html = $encabezado_tabla.$total_body.$footer_tabla;
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "<p>Con estas medidas, confirmamos nuestro gran interés por mejorar nuestras ya buenas relaciones comerciales y no dudamos de su colaboración a la presente norma que se traducirá en beneficio para ambos.</p>";

$pdf->writeHTML($html, true, false, true, false, 'J');

$html = "
<table border=\"0\" align=\"center\">
	<tr>
		<td>_______________________</td>
		<td>_______________________</td>
		<td>_______________________</td>
	</tr>
	<tr>
		<td>
			Transportista<br>
			".ucwords(strtolower($row_orden_compra[8]))."
		</td>
		<td>
			Elaboró<br>
			$row_orden_compra[10]
		</td>
		<td>
			Gerencia<br>
		</td>
	</tr>
</table>
";
$pdf->SetY(235);
$pdf->writeHTML($html, true, false, true, false, 'J');

// add a page
$pdf->AddPage();

// set some text to print
$html="
<br><br>
<h2 style='text-align:center;'>CARTA FALTANTE - SOBRANTE</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html="
<table border=\"0\">
	<tr>
		<td align=\"left\">
			<h3>Sucursal $row_sucursal[0]</h3>
		</td>
		<td align=\"right\">
			<h3>N°. Folio:$row_orden_compra[0]</h3>
		</td>
	</tr>
	<tr>
		<td align=\"left\">
			<h4>Copia para Almacenista</h4>
		</td>
		<td align=\"right\">
			<h4>Fecha: $row_orden_compra[6]</h4>
		</td>
	</tr>
</table>
";

$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<hr>
<p>Estimado Proveedor: $row_proveedor[0]<br>Le comunicamos que con la remesa recibida, cuyos datos abajo detallamos determinamos el siguiente:
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<h2>$row_orden_compra[3]</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "
<p>Para cualquier aclaración, favor de citar nuestro Folio de Entrada No: $row_nota[0]</p>
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$html = "
<table border=\"0\">
	<tr>
		<td>
			De fecha: $row_orden_compra[6]
		</td>
		<td align=\"right\">
			Su Factura: $row_orden_compra[4] 
		</td>
	</tr>
</table>
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$encabezado_tabla = "
<table border=\"1\">
	<tr>
		<th width=\"10%\">Cantidad</th>
		<th width=\"50%\">Descripción</th>
		<th width=\"10%\">U. M.</th>
		<th width=\"15%\">C. U.</th>
		<th width=\"15%\">C. T.</th>
	</tr>";

$cadena_detalle = "SELECT cantidad_producto, descripcion, unidad_medida, costo_unitario, total_renglon FROM detalle_carta_faltante WHERE id_carta_faltante = '$row_orden_compra[0]'";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$total_body = "";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
	$renglon = "
	<tr>
		<td>$row_detalle[0]</td>
		<td align=\"left\"> $row_detalle[1]</td>
		<td>$row_detalle[2]</td>
		<td>$ $row_detalle[3]</td>
		<td>$ $row_detalle[4]</td>
	</tr>
	";
	$total_body = $total_body.$renglon;
}

$footer_tabla="
	<tr>
		<td colspan=\"4\" align=\"right\">
			TOTAL DIFERENCIA: &nbsp;
		</td>
		<td>$ $row_orden_compra[9]</td>
	</tr>
</table>
";
$html = $encabezado_tabla.$total_body.$footer_tabla;
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "<p>Con estas medidas, confirmamos nuestro gran interés por mejorar nuestras ya buenas relaciones comerciales y no dudamos de su colaboración a la presente norma que se traducirá en beneficio para ambos.</p>";

$pdf->writeHTML($html, true, false, true, false, 'J');

$html = "
<table border=\"0\" align=\"center\">
	<tr>
		<td>_______________________</td>
		<td>_______________________</td>
		<td>_______________________</td>
	</tr>
	<tr>
		<td>
			Transportista<br>
			".ucwords(strtolower($row_orden_compra[8]))."
		</td>
		<td>
			Elaboró<br>
			$row_orden_compra[10]</td>
		<td>
			Gerencia<br>
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
