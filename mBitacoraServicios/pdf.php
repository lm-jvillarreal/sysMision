<?php 
    include '../global_seguridad/verificar_sesion.php';
    include '../global_settings/conexion_oracle.php';
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

$id_pago = $_GET['id_pago'];
// $id_pago = '5';
$consulta=mysqli_query($conexion,"SELECT descripcion FROM pagos_servicios WHERE id = '$id_pago' AND activo = '1'");
$row =mysqli_fetch_row($consulta);

$cadena2 = mysqli_query($conexion,"SELECT SUM(bitacora_servicios.gasto),id_proveedor FROM detalle_pago_servicios INNER JOIN bitacora_servicios ON bitacora_servicios.id = detalle_pago_servicios.id_bitacora_servicio WHERE detalle_pago_servicios.activo = '1' AND id_pago = '$id_pago'");
$row2 = mysqli_fetch_array($cadena2);

$cadena_proveedores = "SELECT PR.PROC_CVEPROVEEDOR, CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR = '$row2[1]'";
    $consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
    oci_execute($consulta_proveedores);
    $row_proveedores=oci_fetch_row($consulta_proveedores);

// create some HTML content
$subtable = '<table border="0" cellspacing="0" cellpadding="0"><tr><td>a</td><td>b</td></tr><tr><td>c</td><td>d</td></tr></table>';

$html = '<h3>Pago de Servicios: '.$row[0].'</h3>
         <h4>Proveedor: '.$row_proveedores[1].'</h4>   
<table border="1" cellspacing="0" cellpadding="2">
    <tr>
        <th align="center" width="5%"><b>#</b></th>
        <th align="center" width="25%"><b>Comentario</b></th>
        <th align="center" width="20%"><b>Encargado</b></th>
        <th align="center" width="10%"><b>Gasto</b></th>
        <th align="center" width="40%"><b>Imagen</b></th>
    </tr>';
$n           =1;
$gasto_total = 0;
$imagen      = "";
$cadena = mysqli_query($conexion,"SELECT bitacora_servicios.comentario, bitacora_servicios.nombre_encargado, gasto, bitacora_servicios.fecha_servicio, bitacora_servicios.id FROM detalle_pago_servicios INNER JOIN bitacora_servicios ON bitacora_servicios.id = detalle_pago_servicios.id_bitacora_servicio WHERE id_pago = '$id_pago' ANd detalle_pago_servicios.activo = '1'");
while ($row=mysqli_fetch_row($cadena)) 
{

    $gasto = ($row[2] == "")?'$ 0':'$ '.$row[2];
    $gasto_total += $gasto;
    $total_imagenes = count(glob("images/".$row[4]."/{*.jpg,*.jpeg,*.png}",GLOB_BRACE));
    for ($i=1; $i < $total_imagenes ; $i++) { 
        if (file_exists('images/'.$row[4].'/'.$i.'.jpg')){
            // echo "si";
            $ruta = 'images/'.$row[4].'/'.$i.'.jpg';
            $imagen .= '<img src="'.$ruta.'" alt="test alt attribute" width="90" height="90" border="1" />';
        }else{
            // echo "no";
            $ruta = 'images/'.$row[4].'/'.$i.'.jpeg';
            $imagen .= '<img src="'.$ruta.'" alt="test alt attribute" width="90" height="90" border="1" />';
        }
    }
    if (file_exists('images/'.$row[4].'/0.jpg')){
        $ruta2 = 'images/'.$row[4].'/0.jpg';
        $imagen .= '<img src="'.$ruta2.'" alt="test alt attribute" width="90" height="90" border="1" />';
            
    }else{
        $ruta2 = 'images/'.$row[4].'/0.jpeg';
        $imagen .= '<img src="'.$ruta2.'" alt="test alt attribute" width="90" height="90" border="1" />';
    }
    if(!file_exists($ruta2)){
        $imagen = "";
    }
    //nobr sirve para exitar que los tr salgan mochos cuando abarcan 2 paginas.
    $html .= '<tr nobr="true">
                <td align="center" nobr="true"><b>'.$n.'</b></td>
                <td nobr="true">'.$row[0].'</td>
                <td nobr="true">'.$row[1].'</td>
                <td align="center" nobr="true"><b>'.$gasto.'</b></td>
                <td nobr="true">'.$imagen.'</td>
            </tr>';
    $n ++;
    $imagen = "";
}

$html .= '</table>';

$html .= '<table>
            <tr>
            <td align="right">Monto Total : $'.$row2[0].'</td>
            </tr>
          </table>';

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