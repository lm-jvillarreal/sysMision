<?php 
    include '../global_seguridad/verificar_sesion.php';
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
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
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).   
require_once('../plugins/TCPDF-master/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// // set document information
// $pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor('Nicola Asuni');
// $pdf->SetTitle('TCPDF Example 006');
// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

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
// if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
//     require_once(dirname(__FILE__).'/lang/eng.php');
//     $pdf->setLanguageArray($l);
// }

// ---------------------------------------------------------
// add a page
$pdf->AddPage();
$imagen = "";

$id_pedido = $_GET['id_pedido'];
$consulta=mysqli_query($conexion,"SELECT
    pedido_materiales.nombre,
    CONCAT( personas.nombre, ' ', personas.ap_paterno, ' ', personas.ap_materno ),
    sucursales.nombre,
    DATE_FORMAT(pedido_materiales.fecha, '%d-%m-%Y')
    FROM pedido_materiales
    INNER JOIN usuarios ON usuarios.id = pedido_materiales.id_usuario
    INNER JOIN personas ON personas.id = usuarios.id_persona
    INNER JOIN sucursales ON sucursales.id = personas.id_sede 
    WHERE pedido_materiales.id = '$id_pedido' AND pedido_materiales.activo = '1'");

$row =mysqli_fetch_row($consulta);

$ruta   = "../d_plantilla/dist/img/logo.png";
$imagen .= '<img src="'.$ruta.'" alt="test alt attribute" width="150" border="1" />';

// create some HTML content
$subtable = '<table border="0" cellspacing="0" cellpadding="0"><tr><td>a</td><td>b</td></tr><tr><td>c</td><td>d</td></tr></table>';

$html = '<table border="0" cellspacing="0">
    <tr>
        <th align="center" width="30%">'.$imagen.'</th>
        <th align="center" width="70%"><br><h3>LA MISION SUPERMERCADOS, S.A. DE C.V.</h3></th>
    </tr>
</table><br>';

$html .= '<table border="0" cellspacing="0">
            <tr>
                <th align="center"><h4> RFC: MSU-940322-LJ4</h4></th>
            </tr>
            <tr>
                <th align="center"><h4> DIRECCION: BOULEVARD DIAZ ORDAZ 901 C.P. 67700 CENTRO LINARES N.L</h4></th>
            </tr>
            <tr>
                <th align="center"><h4> TELS. 01(821)212-6200 Y 2126210 </h4></th>
            </tr>
        </table>';

$html .= '<br><br><br><br><table border="0" cellspacing="0">
            <tr>
                <th align="center"><h3> Pedido Sistemas</h3></th>
            </tr>
        </table><br><br>';


$html .= '<br>
                <b>Nombre del Pedido:</b> '.$row[0].'<br>
                <b>Sucursal:</b> '.$row[2].'<br>
                <b>Fecha:</b> '.$row[3].'<br>
                <b>Usuario:</b> '.$row[1].'<br>
          <br>
<table border="1" cellspacing="0" cellpadding="2">
    <tr style="background-color:#FF0000;color:#FFFFFF">
        <th align="center" width="5%"><b>#</b></th>
        <th align="center" width="75%"><b>Descripcion</b></th>
        <th align="center" width="20%"><b>Cantidad</b></th>
    </tr>';
$cadena = mysqli_query($conexion,"SELECT (SELECT nombre FROM catalogo_materiales2 WHERE catalogo_materiales2.id = detalle_pedido.id_material), cantidad FROM detalle_pedido WHERE activo = '1' AND id_pedido = '$id_pedido'");
$numero = 1;
while ($row=mysqli_fetch_row($cadena)) 
{
    //nobr sirve para exitar que los tr salgan mochos cuando abarcan 2 paginas.
    $html .= '<tr nobr="true">
                <td align="center" nobr="true"><b>'.$numero.'</b></td>
                <td nobr="true">'.$row[0].'</td>
                <td nobr="true" align="center"><b>'.$row[1].'</b></td>
            </tr>';
    $numero ++;
    $imagen = "";
}

$html .= '</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFillColor(255,255,0);

// // reset pointer to the last page
$pdf->lastPage();

// // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// // Print a table

// // add a page
// $pdf->AddPage();


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Reporte.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+