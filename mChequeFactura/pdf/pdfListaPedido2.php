<?php
    ob_start();
    error_reporting(E_ALL ^ E_NOTICE);
    include(dirname(__FILE__).'/res/pdfFormaListaPedido2.php');
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../plugins/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('H', 'Letter', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Pedido.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
