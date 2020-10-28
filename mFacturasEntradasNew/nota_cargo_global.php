<?php
	$folio = $_GET['folio'];
    $tipo_mov = $_GET['tipo_mov'];
    $sucursal = $_GET['sucursal'];
$conexion=mysqli_connect("200.1.1.178","jvillarreal","Xoops1991","sysadmision2");
mysqli_set_charset($conexion, "utf8");

    $sel = "SELECT MAX(id) FROM notas_entrada WHERE folio_mov = '$folio' AND id_sucursal = '$sucursal' AND tipo_mov = '$tipo_mov'";
    $exSel = mysqli_query($conexion, $sel);
    $row_s = mysqli_fetch_row($exSel);
    $sql = "SELECT
                id,
                id_nota,
                codigo_producto,
                cantidad,
                diferencia,
                total,
                detalle_nota.descripcion
            FROM
                detalle_nota
            WHERE
                id_nota = '$row_s[0]'
            AND total > 0";
                //echo $sql;
    $select = "SELECT
					folio_mov,
					proveedor,
					factura,
					notas_entrada.fecha,
					concepto,
				CASE
					id_sucursal 
					WHEN 1 THEN
					'Diaz Ordaz' 
					WHEN 2 THEN
					'Arboledas' 
					WHEN 3 THEN
					'Villegas' 
					WHEN 4 THEN
					'Allende' 
				END,
				CONCAT(personas.nombre, ' ', personas.ap_paterno, ' ', personas.ap_materno),
				ROUND(diferencia,2),
				notas_entrada.id,
				dif_impuestos
				FROM
					notas_entrada
					INNER JOIN usuarios ON usuarios.id = notas_entrada.id_usuario
					INNER JOIN personas ON personas.id = usuarios.id_persona
                WHERE
                    notas_entrada.id = '$row_s[0]'";
                    //echo "$select";
$a = mysqli_query($conexion, $select);
$row_a = mysqli_fetch_row($a);

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
$pdf->SetTitle('Nota de cargo');
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
<h2 style='text-align:center;'>Nota de cargo</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html="
<table border=\"0\">
	<tr>
		<td align=\"left\">
			<h3>Sucursal $row_a[5]</h3>
		</td>
		<td align=\"right\">
			<h3>N°. Folio:$row_a[8]</h3>
		</td>
	</tr>
	<tr>
		<td align=\"left\">
			<h4>Realizó: $row_a[6]</h4>
		</td>
		<td align=\"right\">
			<h4>Fecha: $row_a[3]</h4>
		</td>
	</tr>
</table>
";

$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<hr>
<p>Estimado Proveedor: $row_a[1]<br>Le comunicamos que se genera este documento con el listado de diferencias en su factura comparado con nuestra negociacion u orden de compra.
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<h2>Diferencia Global.</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "
<p>Para cualquier aclaración, favor de citar nuestro Folio de Entrada No: $folio</p>
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$html = "
<table border=\"0\">
	<tr>
		<td>
			De fecha: $row_a[3]
		</td>
		<td align=\"right\">
			Su Factura: $row_a[2]
		</td>
	</tr>
</table>
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$encabezado_tabla = "
<table border=\"1\">
	<tr>
		<th width=\"20%\">Articulo</th>
		<th width=\"40%\">Descripción</th>
		<th width=\"10%\">Cant.</th>
		<th width=\"10%\">Dif.$</th>
		<th width=\"10%\">Importe</th>
		<th width=\"10%\">Imp. Neto</th>
	</tr>";

$cadena_detalle = "SELECT
                id,
                id_nota,
                codigo_producto,
                cantidad,
                diferencia,
                total,
                detalle_nota.descripcion,
                total_impuesto,
				impuesto,
				CASE clave_impuesto
				WHEN '1.06' THEN
					'IEPS 6'
				WHEN '1.08' THEN
					'IEPS 8'
				WHEN '1.16' THEN
					'IVA'
				END
            FROM
                detalle_nota
            WHERE
                id_nota = '$row_s[0]'
            AND total > 0";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$total_body = "";
$renglon = "
	<tr>
		<td>N/A</td>
		<td align=\"left\"> Diferencia Global</td>
		<td>1</td>
		<td>$row_a[7]</td>
		<td>$row_a[7]</td>
		<td>$row_a[9]</td>
	</tr>
	";
	$total_body = $total_body.$renglon;
// while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
// 	$renglon = "
// 	<tr>
// 		<td>$row_detalle[2]</td>
// 		<td align=\"left\"> $row_detalle[6]</td>
// 		<td>$row_detalle[3]</td>
// 		<td>$row_detalle[4]</td>
// 		<td>$row_detalle[5]</td>
// 		<td>$row_detalle[7]</td>
// 	</tr>
// 	";
	
// }

$footer_tabla="
	<tr>
		<td colspan=\"4\" align=\"right\">
			TOTAL DIFERENCIA: &nbsp;
		</td>
		<td>$row_a[7]</td>
	</tr>
</table>
";
$html = $encabezado_tabla.$total_body.$footer_tabla;
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "<p>Con estas medidas, confirmamos nuestro gran interés por mejorar nuestras ya buenas relaciones comerciales y no dudamos de su colaboración a la presente norma que se traducirá en beneficio para ambos. Solicitando de la manera mas atenta que genere el documento oficial (nota de credito) o nos refacture con las correcciones.</p>";

$pdf->writeHTML($html, true, false, true, false, 'J');

// $html = "
// <table border=\"0\" align=\"center\">
// 	<tr>
// 		<td>_______________________</td>
// 		<td>_______________________</td>
// 		<td>_______________________</td>
// 	</tr>
// 	<tr>
// 		<td>
// 			Transportista<br>
// 			".ucwords(strtolower($row_a[0]))."
// 		</td>
// 		<td>
// 			Elaboró<br>
// 			1
// 		</td>
// 		<td>
// 			Gerencia<br>
// 		</td>
// 	</tr>
// </table>
// ";
// $pdf->SetY(235);
// $pdf->writeHTML($html, true, false, true, false, 'J');

// add a page
$pdf->AddPage();

// set some text to print
$html="
<br><br>
<h2 style='text-align:center;'>Nota de cargo</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html="
<table border=\"0\">
	<tr>
		<td align=\"left\">
			<h3>Sucursal $row_a[5]</h3>
		</td>
		<td align=\"right\">
			<h3>N°. Folio:$row_a[8]</h3>
		</td>
	</tr>
	<tr>
		<td align=\"left\">
			<h4>Realizó: $row_a[6]</h4>
		</td>
		<td align=\"right\">
			<h4>Fecha: $row_a[3]</h4>
		</td>
	</tr>
</table>
";

$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<hr>
<p>Estimado Proveedor: $row_a[1]<br>Le comunicamos que con la remesa recibida, cuyos datos abajo detallamos determinamos el siguiente:
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$html="
<h2>Diferencia Global.</h2>
";
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "
<p>Para cualquier aclaración, favor de citar nuestro Folio de Entrada No: $folio</p>
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$html = "
<table border=\"0\">
	<tr>
		<td>
			De fecha: $row_a[3]
		</td>
		<td align=\"right\">
			Su Factura: $row_a[2]
		</td>
	</tr>
</table>
";
$pdf->writeHTML($html, true, false, true, false, 'J');

$encabezado_tabla = "
<table border=\"1\">
	<tr>
		<th width=\"15%\">Articulo</th>
		<th width=\"40%\">Descripción</th>
		<th width=\"10%\">Cant.</th>
		<th width=\"10%\">Dif.$</th>
		<th width=\"10%\">Importe</th>
		<th width=\"10%\">Imp. Neto</th>
	</tr>";

$cadena_detalle = "SELECT
                id,
                id_nota,
                codigo_producto,
                cantidad,
                diferencia,
                total,
                detalle_nota.descripcion,
                total_impuesto,
				impuesto,
				CASE clave_impuesto
				WHEN '1.06' THEN
					'IEPS 6'
				WHEN '1.08' THEN
					'IEPS 8'
				WHEN '1.16' THEN
					'IVA'
				END
            FROM
                detalle_nota
            WHERE
                id_nota = '$row_s[0]'
            AND total > 0";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$total_body = "";
$renglon = "
	<tr>
		<td>N/A</td>
		<td align=\"left\"> Diferencia Global</td>
		<td>1</td>
		<td>$row_a[7]</td>
		<td>$row_a[7]</td>
		<td>$row_a[9]</td>
	</tr>
	";
	$total_body = $total_body.$renglon;
// while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
// 	$renglon = "
// 	<tr>
// 		<td>$row_detalle[2]</td>
// 		<td align=\"left\"> $row_detalle[6]</td>
// 		<td>$row_detalle[3]</td>
// 		<td>$ $row_detalle[4]</td>
// 		<td>$ $row_detalle[5]</td>
// 		<td>$ $row_detalle[7]</td>
// 	</tr>
// 	";
// 	$total_body = $total_body.$renglon;
// }

$footer_tabla="
	<tr>
		<td colspan=\"4\" align=\"right\">
			TOTAL DIFERENCIA: &nbsp;
		</td>
		<td>$row_a[7]</td>
	</tr>
</table>
";
$html = $encabezado_tabla.$total_body.$footer_tabla;
$pdf->writeHTML($html, true, false, true, false, 'C');

$html = "<p>Con estas medidas, confirmamos nuestro gran interés por mejorar nuestras ya buenas relaciones comerciales y no dudamos de su colaboración a la presente norma que se traducirá en beneficio para ambos. Solicitando de la manera mas atenta que genere el documento oficial (nota de credito) o nos refacture con las correcciones.</p>";

$pdf->writeHTML($html, true, false, true, false, 'J');

// $html = "
// <table border=\"0\" align=\"center\">
// 	<tr>
// 		<td>_______________________</td>
// 		<td>_______________________</td>
// 		<td>_______________________</td>
// 	</tr>
// 	<tr>
// 		<td>
// 			Transportista<br>
// 			".ucwords(strtolower(1))."
// 		</td>
// 		<td>
// 			Elaboró<br>
// 			1</td>
// 		<td>
// 			Gerencia<br>
// 		</td>
// 	</tr>
// </table>
// ";
// $pdf->SetY(235);
// $pdf->writeHTML($html, true, false, true, false, 'J');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
