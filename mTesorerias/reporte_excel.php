<?php

$folio = $_GET['folio'];

include '../global_settings/conexion.php';

$cadena = "SELECT
                faltantes.moneda,
                faltantes.faltante,
                faltantes.valor
            FROM
                faltantes
            WHERE folio = '$folio'";
$resultado = $conexion->query($cadena);

$cadena2 = "SELECT
                SUM(faltante),
                SUM(valor),
                CONCAT(
                    personas.nombre,
                    ' ',
                    personas.ap_paterno,
                    ' ',
                    personas.ap_materno
                ) AS Nombre,
                sucursales.nombre,
                DATE_FORMAT(faltantes.fecha, '%d/%m/%Y')
            FROM
                faltantes
            INNER JOIN usuarios ON usuarios.id = faltantes.id_usuario
            INNER JOIN personas ON personas.id = usuarios.id_persona
            INNER JOIN sucursales ON sucursales.id = faltantes.id_sucursal
            WHERE
                folio = '$folio'";
$resultado2 = $conexion->query($cadena2);
$row_suma = mysqli_fetch_array($resultado2);

if($resultado->num_rows > 0 )
    {

        date_default_timezone_set('America/Mexico_City');

        if (PHP_SAPI == 'cli')
            die('Este archivo solo se puede ver desde un navegador web');

        /** Se agrega la libreria PHPExcel */
        require_once '../plugins/PHPExcel/Classes/PHPExcel.php';

        // Se crea el objeto PHPExcel
        $objPHPExcel = new PHPExcel();

        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("Mision") //Autor
                             ->setLastModifiedBy("Mision") //Ultimo usuario que lo modificó
                             ->setTitle("Reporte General")
                             ->setSubject("Reporte General")
                             ->setDescription("Reporte General")
                             ->setKeywords("Reporte General")
                             ->setCategory("Reporte General");

        $titulosColumnas = array('Faltantes de Morralla','Sucursal:','Usuario:','Fecha:','Monedas','Faltante','Valor $','Total Monedas');


        // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1',  $titulosColumnas[0])
                    ->setCellValue('A2',  $titulosColumnas[1])
                    ->setCellValue('A3',  $titulosColumnas[2])
                    ->setCellValue('A4',  $titulosColumnas[3])
                    ->setCellValue('A5',  $titulosColumnas[4])
                    ->setCellValue('B5',  $titulosColumnas[5])
                    ->setCellValue('C5',  $titulosColumnas[6])
                    ->setCellValue('A14',  $titulosColumnas[7]);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B14', $row_suma[0])
            ->setCellValue('C14', $row_suma[1]);
        
        $i = 6;
        while ($row_faltante = mysqli_fetch_array($resultado)) 
        {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $row_faltante[0]) 
                ->setCellValue('B'.$i, $row_faltante[1]) 
                ->setCellValue('C'.$i, $row_faltante[2]);
            $i++;
        }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B14',$row_suma[0])
                ->setCellValue('C14',$row_suma[1])
                ->setCellValue('B2',$row_suma[3])
                ->setCellValue('B3',$row_suma[2])
                ->setCellValue('B4',$row_suma[4]);

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
            ));

         $estilodemas = array(
         'alignment' =>  array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'          => TRUE
            ));
            
         
         $objPHPExcel->getActiveSheet()->getStyle('c1')->applyFromArray($estiloTituloReporte);
         
         $objPHPExcel->getActiveSheet()->getStyle('A14:C14')->applyFromArray($estiloTituloColumnas);

         for ($i=1; $i <= 5 ; $i++) { 
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':C'.$i)->applyFromArray($estiloTituloColumnas);
         }

         for ($o=6; $o <= 13; $o++) { 
            $objPHPExcel->getActiveSheet()->getStyle('A'.$o.':C'.$o)->applyFromArray($estilodemas);
         }
        // $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:B".($i-1));
                
        for($i = 'A'; $i <= 'C'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)            
                ->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1'); //Combinar celdas
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B3:C3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B4:C4');

        for ($i=6; $i <= 13 ; $i++) { 
          $objPHPExcel->getActiveSheet()->getStyle("A".$i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

          $objPHPExcel->getActiveSheet()->getStyle("C".$i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        }

        $objPHPExcel->getActiveSheet()->getStyle("C14")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle('Reporte Faltantes');

        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);

        // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte_Faltantes.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
else
    {
      print_r('No hay resultados para mostrar');
    }
?>