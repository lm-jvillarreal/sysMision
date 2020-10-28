<?php
    require_once('conexion/conexion.php');
    error_reporting(E_ALL ^E_NOTICE);
    date_default_timezone_set("America/Monterrey");
    $id = $_GET['id'];
    $sel = "SELECT folio_mov FROM notas_entrada WHERE id = '$id'";
    $exSel = mysqli_query($mysqli, $sel);
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
                id_nota = '$id'";
                //echo $sql;
    $select = "SELECT
                    folio_mov,
                    proveedor,
                    factura,
                    fecha,
                    concepto,
                CASE id_sucursal
                WHEN 1 THEN
                    'Diaz Ordaz'
                WHEN 2 THEN
                    'Arboledas'
                WHEN 3 THEN
                    'Villegas'
                WHEN 4 THEN
                    'Allende'
                END
                FROM
                    notas_entrada
                WHERE
                    notas_entrada.id = '$id'";
$a = mysqli_query($mysqli, $select);
$row_a = mysqli_fetch_row($a);


// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');
require_once('tcpdf/tcpdf.php');
$sucursal = $row_a[5];
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 005');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'La Mision Supermercados S.A. de C.V.', 'Nota de cargo. Sucursal: '. $sucursal);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 15));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 127);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// set some text for example
$text = '';
$text = '<div class="row">
            <div class="col-md-12">
                <h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1>
              <table border = "1">
                <thead>
                  <tr>
                    <th align="center">Proveedor</th>
                    <th align="center">Factura</th>
                    <th align="center">Entrada</th>
                    <th align="left">Concepto</th>
                    <th align="center">Fecha</th>
                  </tr>
                </thead>';
    $datos2=$mysqli->query($select);
    while ($user2=$datos2->fetch_row()) {     
        $text .= '
            <tr>
                <td align="center">'.$user2[1].'</td>
                <td align="center">'.$user2[2].'</td>
                <td align="center">'.$user2[0].'</td>
                <td align="left">'.$user2[4].'</td>
                <td align = "center">'.$user2[3].'</td> 
            </tr>
        ';
        }
        $text .= '</table>';
$pdf->writeHTML($text, false, 0, false, 0);

$txt = '';
$txt .= '<div class="row">
            <div class="col-md-12">
                <h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1>
        
      <table cellpadding="1">
        <thead>
          <tr>
            <th align="center">Articulo</th>
            <th align="center">Descripcion</th>
            <th align="center">Cantidad</th>
            <th align="left">Diferencia</th>
            <th align="center">Importe</th>
          </tr>
        </thead>';
    $datos=$mysqli->query($sql);
    while ($user=$datos->fetch_row()) {     
        $txt .= '
            <tr>
                <td align="center">'.$user[2].'</td>
                <td align="center">'.$user[6].'</td>
                <td align="center">'.$user[3].'</td>
                <td align="left">'.$user[4].'</td>
                <td align="center">'.$user[5].'</td>
            </tr>
        ';
        }
        $txt .= '</table>';

$pdf->writeHTML($txt, true, 0, true, 0);

$t = "SELECT SUM(total) FROM detalle_nota WHERE id_nota = '$id'";
$tt = '<div class="row">
            <div class="col-md-12">
                <h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1>
              <table border = "1">
                <thead>
                  <tr>
                    <th align="center">Total sin impuestos</th>
                  </tr>
                </thead>';
    $datos3=$mysqli->query($t);
    while ($user3=$datos3->fetch_row()) {     
        $tt .= '
            <tr>
                <td align="center">'.'$'.round($user3[0], 2).'</td>
            </tr>
        ';
        }
        $tt .= '</table>';
        $pdf->writeHTML($tt, true, 0, true, 0);


// Multicell test
//$pdf->MultiCell(170, 5, $var, 1, 'L', 1, 0, '', '', true);
// $pdf->MultiCell(55, 5, '[RIGHT] '.$txt, 1, 'R', 0, 1, '', '', true);
// $pdf->MultiCell(55, 5, '[CENTER] '.$txt, 1, 'C', 0, 0, '', '', true);
// $pdf->MultiCell(55, 5, '[JUSTIFY] '.$txt."\n", 1, 'J', 1, 2, '' ,'', true);
// $pdf->MultiCell(55, 5, '[DEFAULT] '.$txt, 1, '', 0, 1, '', '', true);

// $pdf->Ln(4);

// // set color for background
// $pdf->SetFillColor(220, 255, 220);

// // Vertical alignment
// $pdf->MultiCell(55, 40, '[VERTICAL ALIGNMENT - TOP] '.$txt, 1, 'J', 1, 0, '', '', true, 0, false, true, 40, 'T');
// $pdf->MultiCell(55, 40, '[VERTICAL ALIGNMENT - MIDDLE] '.$txt, 1, 'J', 1, 0, '', '', true, 0, false, true, 40, 'M');
// $pdf->MultiCell(55, 40, '[VERTICAL ALIGNMENT - BOTTOM] '.$txt, 1, 'J', 1, 1, '', '', true, 0, false, true, 40, 'B');

// $pdf->Ln(4);

// // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// // set color for background
// $pdf->SetFillColor(215, 235, 255);

// // set some text for example
// $txt = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed imperdiet lectus. Phasellus quis velit velit, non condimentum quam. Sed neque urna, ultrices ac volutpat vel, laoreet vitae augue. Sed vel velit erat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras eget velit nulla, eu sagittis elit. Nunc ac arcu est, in lobortis tellus. Praesent condimentum rhoncus sodales. In hac habitasse platea dictumst. Proin porta eros pharetra enim tincidunt dignissim nec vel dolor. Cras sapien elit, ornare ac dignissim eu, ultricies ac eros. Maecenas augue magna, ultrices a congue in, mollis eu nulla. Nunc venenatis massa at est eleifend faucibus. Vivamus sed risus lectus, nec interdum nunc.

// Fusce et felis vitae diam lobortis sollicitudin. Aenean tincidunt accumsan nisi, id vehicula quam laoreet elementum. Phasellus egestas interdum erat, et viverra ipsum ultricies ac. Praesent sagittis augue at augue volutpat eleifend. Cras nec orci neque. Mauris bibendum posuere blandit. Donec feugiat mollis dui sit amet pellentesque. Sed a enim justo. Donec tincidunt, nisl eget elementum aliquam, odio ipsum ultrices quam, eu porttitor ligula urna at lorem. Donec varius, eros et convallis laoreet, ligula tellus consequat felis, ut ornare metus tellus sodales velit. Duis sed diam ante. Ut rutrum malesuada massa, vitae consectetur ipsum rhoncus sed. Suspendisse potenti. Pellentesque a congue massa.';

// // print a blox of text using multicell()
// $pdf->MultiCell(80, 5, $txt."\n", 1, 'J', 1, 1, '' ,'', true);

// // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// // AUTO-FITTING

// // set color for background
// $pdf->SetFillColor(255, 235, 235);

// // Fit text on cell by reducing font size
// $pdf->MultiCell(55, 60, '[FIT CELL] '.$txt."\n", 1, 'J', 1, 1, 125, 145, true, 0, false, true, 60, 'M', true);

// // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// // CUSTOM PADDING

// // set color for background
// $pdf->SetFillColor(255, 255, 215);

// // set font
// $pdf->SetFont('helvetica', '', 8);

// // set cell padding
// $pdf->setCellPaddings(2, 4, 6, 8);

// $txt = "CUSTOM PADDING:\nLeft=2, Top=4, Right=6, Bottom=8\nLorem ipsum dolor sit amet, consectetur adipiscing elit. In sed imperdiet lectus. Phasellus quis velit velit, non condimentum quam. Sed neque urna, ultrices ac volutpat vel, laoreet vitae augue.\n";

// $pdf->MultiCell(55, 5, $txt, 1, 'J', 1, 2, 125, 210, true);

// move pointer to last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_005.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

