<?php
include '../global_settings/conexion.php';
date_default_timezone_set('America/Monterrey');
// header( "Content-type: application/vnd.ms-excel; charset=UTF-8" );

    // date_default_timezone_set('America/Mexico_City');

    if (PHP_SAPI == 'cli')
        die('Este archivo solo se puede ver desde un navegador web');

    /** Se agrega la libreria PHPExcel */
    require_once '../plugins/PHPExcel/Classes/PHPExcel.php';

    // Se crea el objeto PHPExcel
    $objPHPExcel = new PHPExcel();

    // Se asignan las propiedades del libro
    $objPHPExcel->getProperties()->setCreator("Mision") //Autor
                         ->setLastModifiedBy("Mision") //Ultimo usuario que lo modificó
                         ->setTitle("Plantilla Preguntas")
                         ->setSubject("Plantilla Preguntas")
                         ->setDescription("Plantilla Preguntas")
                         ->setKeywords("Plantilla Preguntas")
                         ->setCategory("Plantilla Preguntas");


    // Se agregan los titulos del reporte
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1',  'Nombre de Pregunta')
                ->setCellValue('B1',  'Tipo de Pregunta');
    
     $estiloTituloReporte = array(
        'font' => array(
            'name'      => 'Arial',
            'bold'      => true,
            'italic'    => false,
             'strike'    => false,
                'size' =>14,
                'color'     => array(
                    'rgb' => '#000000'
                )
         ));

     $estiloTituloColumnas = array(
         'font' => array(
             'name'      => 'Arial',
             'size'      => '11',
             'bold'      => true,                          
             'color'     => array(
                 'rgb' => '#000000'
             )
         ),

        'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
        )
    );
    
    // $objPHPExcel->getActiveSheet(0)->getColumnDimension('A')->setAutoSize(true);
    for($i = 'A'; $i <= 'C'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
    }

     $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getAlignment()->setWrapText(true);

     $estilodemas = array(
     'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
        ));
        
     
     $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->applyFromArray($estiloTituloColumnas);
    // $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:B".($i-1));

	// $sheet->getStyle("A6:C6")->applyFromArray($style);

    //$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setVisible(false); 

    // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Plantilla Preguntas');

    // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);

    // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="plantilla.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
?>