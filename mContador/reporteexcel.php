<?php
include '../global_settings/conexion.php';
date_default_timezone_set('America/Monterrey');

$fecha_inicio = $_GET['fecha_inicio'];
$fecha_ini    = date("d/m/Y", strtotime($fecha_inicio));
$fecha_final  = $_GET['fecha_final'];
$fecha_fin    = date("d/m/Y", strtotime($fecha_final));

$suma           = 0;
$total          = 0;
$totaldo        = 0;
$totalar        = 0;
$totalvill      = 0;
$totalall       = 0;
$faltante_total = 0;
$valor_total    = 0;

$cadena = "SELECT
                    tabla.moneda,
                    tabla.ODiaz,
                    tabla.Arboledas,
                    tabla.Villegas,
                    tabla.Allende
                FROM
                    (
                        SELECT
                            moneda,id,
                            (
                                SELECT
                                    SUM(faltante)
                                FROM
                                    faltantes f
                                WHERE
                                    id_sucursal = '1'
                                AND f.moneda = faltantes.moneda
                                AND f.activo = '1'
                                AND fecha BETWEEN CAST('$fecha_inicio' AS DATE)
                                AND CAST('$fecha_final' AS DATE)
                            ) AS ODiaz,
                            (
                                SELECT
                                    SUM(faltante)
                                FROM
                                    faltantes f
                                WHERE
                                    id_sucursal = '2'
                                AND f.moneda = faltantes.moneda
                                AND f.activo = '1'
                                AND fecha BETWEEN CAST('$fecha_inicio' AS DATE)
                                AND CAST('$fecha_final' AS DATE)
                            ) AS Arboledas,
                            (
                                SELECT
                                    SUM(faltante)
                                FROM
                                    faltantes f
                                WHERE
                                    id_sucursal = '3'
                                AND f.moneda = faltantes.moneda
                                AND f.activo = '1'
                                AND fecha BETWEEN CAST('$fecha_inicio' AS DATE)
                                AND CAST('$fecha_final' AS DATE)
                            ) AS Villegas,
                            (
                                SELECT
                                    SUM(faltante)
                                FROM
                                    faltantes f
                                WHERE
                                    id_sucursal = '4'
                                AND f.moneda = faltantes.moneda
                                AND f.activo = '1'
                                AND fecha BETWEEN CAST('$fecha_inicio' AS DATE)
                                AND CAST('$fecha_final ' AS DATE)
                            ) AS Allende
                        FROM
                            faltantes
                        GROUP BY 
                            faltantes.moneda
                        ORDER BY
                            faltantes.id
                    ) AS tabla";
$resultado = $conexion->query($cadena);


if($resultado->num_rows > 0 )
    {

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
                             ->setTitle("Reporte General")
                             ->setSubject("Reporte General")
                             ->setDescription("Reporte General")
                             ->setKeywords("Reporte General")
                             ->setCategory("Reporte General");

        $titulosColumnas = array('Faltantes de Morralla (Resumen)','Fecha Inicial','Fecha Final','Monedas','Falt.DO','Falt.Arboledas','Falt.Villegas','Falt.Allende','Falt.Total','Valor','Total de de Monedas');


        // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1',  $titulosColumnas[0])
                    ->setCellValue('A2',  $titulosColumnas[1])
                    ->setCellValue('D2',  $titulosColumnas[2])
                    ->setCellValue('A3',  $titulosColumnas[3])
                    ->setCellValue('B3',  $titulosColumnas[4])
                    ->setCellValue('C3',  $titulosColumnas[5])
                    ->setCellValue('D3',  $titulosColumnas[6])
                    ->setCellValue('E3',  $titulosColumnas[7])
                    ->setCellValue('F3',  $titulosColumnas[8])
                    ->setCellValue('G3',  $titulosColumnas[9])
                    ->setCellValue('A12',  $titulosColumnas[10]);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', $fecha_ini)
            ->setCellValue('E2', $fecha_fin);
        
        $i = 4;
        while ($row_faltante = mysqli_fetch_array($resultado)) 
        {
            if ($row_faltante[1] == ""){ $row_faltante[1] = 0;}
            if ($row_faltante[2] == ""){ $row_faltante[2] = 0;}
            if ($row_faltante[3] == ""){ $row_faltante[3] = 0;}
            if ($row_faltante[4] == ""){ $row_faltante[4] = 0;}
            $suma = $row_faltante[1]+$row_faltante[2]+$row_faltante[3]+$row_faltante[4];

            $total = $suma * $row_faltante[0];

            $totaldo   = $totaldo + $row_faltante[1];
            $totalar   = $totalar + $row_faltante[2];
            $totalvill = $totalvill + $row_faltante[3];
            $totalall  = $totalall + $row_faltante[4];

            $faltante_total = $faltante_total + $suma;
            $valor_total = $valor_total + $total;

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $row_faltante[0]) 
                ->setCellValue('B'.$i, $row_faltante[1]) 
                ->setCellValue('C'.$i, $row_faltante[2]) 
                ->setCellValue('D'.$i, $row_faltante[3]) 
                ->setCellValue('E'.$i, $row_faltante[4])
                ->setCellValue('F'.$i, $suma)
                ->setCellValue('G'.$i, $total); 
            $i++;
        }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B12',$totaldo)
                ->setCellValue('C12',$totalar)
                ->setCellValue('D12',$totalvill)
                ->setCellValue('E12',$totalall)
                ->setCellValue('F12',$faltante_total)
                ->setCellValue('G12',$valor_total);

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
         $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($estiloTituloColumnas);     
         $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($estiloTituloColumnas);
         $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($estiloTituloColumnas);
         $objPHPExcel->getActiveSheet()->getStyle('A12:G12')->applyFromArray($estiloTituloColumnas);

         $objPHPExcel->getActiveSheet()->getStyle('A4:G4')->applyFromArray($estilodemas);
         $objPHPExcel->getActiveSheet()->getStyle('A5:G5')->applyFromArray($estilodemas);
         $objPHPExcel->getActiveSheet()->getStyle('A6:G6')->applyFromArray($estilodemas);
         $objPHPExcel->getActiveSheet()->getStyle('A7:G7')->applyFromArray($estilodemas);
         $objPHPExcel->getActiveSheet()->getStyle('A8:G8')->applyFromArray($estilodemas);
         $objPHPExcel->getActiveSheet()->getStyle('A9:G9')->applyFromArray($estilodemas);
         $objPHPExcel->getActiveSheet()->getStyle('A10:G10')->applyFromArray($estilodemas);
         $objPHPExcel->getActiveSheet()->getStyle('A11:G11')->applyFromArray($estilodemas);
        // $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:B".($i-1));
                
        for($i = 'A'; $i <= 'G'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)            
                ->getColumnDimension($i)->setAutoSize(TRUE);
        }

        for ($i=4; $i <= 11 ; $i++) { 
            $objPHPExcel->getActiveSheet()->getStyle("A".$i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        }

        for ($i=4; $i <= 12 ; $i++) { 
            $objPHPExcel->getActiveSheet()->getStyle("G".$i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        }

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1'); //Combinar celdas
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:F2');

         $style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	    );

    	// $sheet->getStyle("A6:C6")->applyFromArray($style);

        //$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setVisible(false); 

        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle('Reporte Faltantes');

        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);

        // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte_Resumen_Faltantes.xlsx"');
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