<?php
    require_once('conexion/conexion.php');
    error_reporting(E_ALL ^E_NOTICE);
    date_default_timezone_set("America/Monterrey");
    $folio = $_GET['folio'];
    $tipo_mov = $_GET['tipo_mov'];
    $sucursal = $_GET['sucursal'];
    $sel = "SELECT MAX(id) FROM notas_entrada WHERE folio_mov = '$folio' AND id_sucursal = '$sucursal' AND tipo_mov = '$tipo_mov'";
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
                id_nota = '$row_s[0]'
            AND total > 0";
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
                    notas_entrada.id = '$row_s[0]'";
                    //echo "$select";
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

$t = "SELECT SUM(total) FROM detalle_nota WHERE id_nota = '$row_s[0]'";
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




// move pointer to last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_005.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

