<?php
    ob_start();
    error_reporting(E_ALL ^ E_NOTICE);
    include(dirname(__FILE__).'/res/pdfFormaPrestamo.php');
    date_default_timezone_set('America/Monterrey');
    $content = ob_get_clean();

    // convert to PDF
    //  anterior url
    require_once(dirname(__FILE__).'/../../plugins/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('H', 'Letter', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Acta Administrativa.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
