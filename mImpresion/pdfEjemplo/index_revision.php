<?php 
error_reporting(E_ALL ^ E_NOTICE);
    require_once('conexion/conexion.php');
    //require_once('conexion/conexion_oracle.php');
    ///include 'conexion/conexion_oracle.php';
    $id = $_GET['id'];  
    $sql = "SELECT
                detalle_mapeo.estante,
                detalle_mapeo.consecutivo_mueble,
                detalle_mapeo.codigo_producto,
                detalle_mapeo.descripcion,
                
                mapeo.cara,
                mapeo.mueble,
                mapeo.id_sucursal,
                detalle_mapeo.id,
                detalle_mapeo.codigo_producto
              FROM
                inv_detalle_mapeo detalle_mapeo
              
              INNER JOIN inv_mapeo mapeo ON mapeo.id = detalle_mapeo.id_mapeo
              WHERE mapeo.id = '$id'
              GROUP BY detalle_mapeo.id 
              ORDER BY detalle_mapeo.estante, detalle_mapeo.consecutivo_mueble";
    $datos=$mysqli->query($sql);
    $q = "SELECT
                mapeo.zona,
                mapeo.mueble,
                mapeo.cara,
                sucursales.nombre,
                usuarios.nombre_usuario,
                mapeo.id
            FROM
                inv_mapeo mapeo
            INNER JOIN sucursales ON sucursales.id = mapeo.id_sucursal
            inner join usuarios on usuarios.id = mapeo.usuario
            WHERE
                mapeo.id = '$id'";
    $suc=$mysqli->query($q);
    $s=$suc->fetch_row();
    $sucursal = $s[3];
    $zona = $s[0];
    $mueble = $s[1];
    $cara = $s[2];
    $usuario = $s[4];
    $folio = $s[5];


  date_default_timezone_set('America/Monterrey');
  $fecha = date('Y-m-d');
  $hora = date('H:i:s');
//============================================================+
// File name   : example_003.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
//               Custom Header and Footer
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
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        global $sucursal;
        global $zona;
        global $mueble;
        global $cara;
        global $fecha;
        global $usuario;
        global $folio;
        // Logo
        //$image_file = K_PATH_IMAGES.'logo_example.jpg';
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 8);
        // Title
        $this->Cell(0, 8, 'La Mision Supermercados Suc.'.$sucursal, 0, true, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 5, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, true, 'R', 0, '', 0, false, 'T', 'M');
        //$this->Cell(0, 5, 'Prelistados para inventarios', 0, true, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 7, 'Folio: '. $folio, 0, true, 'L', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 7, 'Zona: '. $zona, 0, true, 'L', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 7, 'Mueble: '. $mueble, 0, true, 'L', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 7, 'Cara: '. $cara, 0, true, 'L', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 0, 'Fecha: '. $fecha, 0, true,'L', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 10, 'Usuario: '. $usuario, 0, true,'L', 0, '', 0, false, 'M', 'M');


    }

    // Page footer
    public function Footer() {
        
        global $fecha;
        // Position at 15 mm from bottom
        $this->SetY(-50);
        // Set font
        $this->SetFont('helvetica', 8);
        $image_file = K_PATH_IMAGES.'footer.png';
        $this->Image($image_file, 10, 272, 190, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);      
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
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
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(PDF_MARGIN_LEFT-10, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT-10);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM+10);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('courier', 'N', 9);

// add a page
$pdf->AddPage();

// set some text to print

$content = '';
    
    $content .= '
        <div class="row">
            <div class="col-md-12">
                <h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1>
        
      <table cellpadding="1">
        <thead>
          <tr>
            <th width="5%" align="center">Niv.</th>
            <th width="5%" align="center">Con.</th>
            <th width="16%" align="center">Codigo</th>
            <th width="42%" align="left">Descripcion</th>
            <th width="32%" align="left">Depto</th>

          </tr>
        </thead>
    ';
    
    $n = 1;
    while ($user=$datos->fetch_row()) { 
        $query_oracle= "SELECT (SELECT 
                            (SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS F WHERE f.FAMC_FAMILIA = COM_FAMILIAS.FAMC_FAMILIAPADRE ) 
                        FROM COM_FAMILIAS 
                        WHERE FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA) FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$user[8]'";
        $st = oci_parse($conexion_central, $query_oracle);
        oci_execute($st);
        $row_oracle = oci_fetch_row($st);
            
    $content .= '
        <tr>
            <td width="5%" align="center">'.$user[0].'</td>
            <td width="5%" align="center">'.$n.'</td>
            <td width="16%" align="center">'.$user[8].'</td>
            <td width="42%" align="left">'.$user[3].'</td>
            <td width="32%" align="left">'.$row_oracle[0].'</td>

        </tr>
    ';

    $n = $n + 1;
        }
    
    $content .= '</table>';
    
    
    $pdf->writeHTML($content, true, 0, true, 0);

    $pdf->lastPage();
    $pdf->output('Reporte.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+