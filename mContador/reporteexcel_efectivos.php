<?php
include '../global_settings/conexion.php';
date_default_timezone_set('America/Monterrey');

$fecha_inicio = $_GET['fecha_inicio'];
$fecha_ini = date("d/m/Y", strtotime($fecha_inicio));
$fecha_final  = $_GET['fecha_final'];
$fecha_fin = date("d/m/Y", strtotime($fecha_final));

        if (PHP_SAPI == 'cli')
            die('Este archivo solo se puede ver desde un navegador web');

        /** Se agrega la libreria PHPExcel */
        require_once '../plugins/PHPExcel/Classes/PHPExcel.php';

        // Se crea el objeto PHPExcel
        $objPHPExcel = new PHPExcel();

        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("Mision") //Autor
                             ->setLastModifiedBy("Mision") //Ultimo usuario que lo modificó
                             ->setTitle("Reporte Efectivos")
                             ->setSubject("Reporte Efectivos")
                             ->setDescription("Reporte Efectivos")
                             ->setKeywords("Reporte Efectivos")
                             ->setCategory("Reporte Efectivos");

        $titulosColumnas = array('Efectivos (RESUMEN)','Fecha Inicial:','Fecha Final:','Efectivo:','Efectivo 1:','Efectivo 2:','Complemento:','Cheques Serfin:','Cheques Locales:','Total Efectivos:','Tarjetas de Credito:','Tarjetas Varias','Debito:','Prepago:','ACCOR:','Ecovale:','Efectivale:','Si Vale:','Tienda PASS:','Total:','Bonos','Prestaciones Mexicanas:','Prestaciones Universales:','ACCOR:','Efectivale:','La Mision Especial:','Creditos:','Total Bonos:','Otros');


        // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1',  $titulosColumnas[0]) //Resumen
                    ->setCellValue('A2',  $titulosColumnas[1]) //FechaIni
                    ->setCellValue('D2',  $titulosColumnas[2]) //FechaFin
                    ->setCellValue('A5',  $titulosColumnas[3]) //Efectivos
                    ->setCellValue('A6',  $titulosColumnas[4]) //Efectivo1
                    ->setCellValue('A7',  $titulosColumnas[5]) //Efectivo2
                    ->setCellValue('A8',  $titulosColumnas[6]) //Complemento
                    ->setCellValue('A9',  $titulosColumnas[7]) //Cheques Serfin
                    ->setCellValue('A10',  $titulosColumnas[8]) //Cheques Locales
                    ->setCellValue('A11',  $titulosColumnas[9]) //Total Efectivos
                    ->setCellValue('A13',  $titulosColumnas[10]) //Tarjetas Credito
                    ->setCellValue('A15',  $titulosColumnas[11]) //Tarjetas Varias
                    ->setCellValue('A16',  $titulosColumnas[12]) //Debito
                    ->setCellValue('A17',  $titulosColumnas[13]) //Prepago
                    ->setCellValue('A18',  $titulosColumnas[14]) //ACCOR
                    ->setCellValue('A19',  $titulosColumnas[15]) //Ecovale
                    ->setCellValue('A20',  $titulosColumnas[16]) //Efectivale
                    ->setCellValue('A21',  $titulosColumnas[17]) //Sivale
                    ->setCellValue('A22',  $titulosColumnas[18]) //TiendaPASS
                    ->setCellValue('A23',  $titulosColumnas[19]) //Total
                    ->setCellValue('A25',  $titulosColumnas[20]) //Bonos
                    ->setCellValue('A26',  $titulosColumnas[21]) //Prestaciones Mex.
                    ->setCellValue('A27',  $titulosColumnas[22]) //Prestaciones Uni.
                    ->setCellValue('A28',  $titulosColumnas[23]) //ACCOR
                    ->setCellValue('A29',  $titulosColumnas[24]) //Efectivale
                    ->setCellValue('A30',  $titulosColumnas[25]) //La Mision Especial
                    ->setCellValue('A31',  $titulosColumnas[26]) //Creditos
                    ->setCellValue('A32',  $titulosColumnas[27]) //Total Bonos
                    ->setCellValue('A36',  $titulosColumnas[28]); //Otros

        $bd = array(0 => 'efectivo',
                    1 => 'efectivo1',
                    2 => 'efectivo2',
                    3 => 'complemento',
                    4 => 'cheques_serfin',
                    5 => 'cheques_locales',
                    6 => 'total_efectivos',
                    7 => 'tarjetas_credito',
                    8 => 't_debito',
                    9 => 't_prepago', 
                    10 => 't_accor',
                    11 => 't_ecovale',
                    12 => 't_efectivale',
                    13 => 't_sivale',
                    14 => 't_tiendapass',
                    15 => 'total_t',
                    16 => 'b_prest_mex',
                    17 => 'b_prest_uni',
                    18 => 'b_accor',
                    19 => 'b_efectivale',
                    20 => 'b_mision_esp',
                    21 => 'b_creditos',
                    22 => 'b_total');

        $excel = array(0 => 5,
                      1 => 6,
                      2 => 7,
                      3 => 8,
                      4 => 9,
                      5 => 10,
                      6 => 11,
                      7 => 13,
                      8 => 16,
                      9 => 17,
                      10 => 18,
                      11 => 19,
                      12 => 20,
                      13 => 21,
                      14 => 22,
                      15 => 23,
                      16 => 26,
                      17 => 27,
                      18 => 28,
                      19 => 29,
                      20 => 30,
                      21 => 31,
                      22 => 32,
                      23 => 31,
                      24 => 33,
                      25 => 34);

        $cuerpo = "";
        $numero = 0;
        $total_general_do = 0;
        $total_general_ar = 0;
        $total_general_vi = 0;
        $total_general_al = 0;

        for ($i=0; $i <= 22; $i++) {
          $numero = $i + 1;
          $cadena = "SELECT
                        *
                      FROM
                        (
                          SELECT
                            (
                              SELECT
                                SUM($bd[$i])
                              FROM
                                efectivos
                              WHERE
                                id_sucursal = '1'
                              AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE)
                              AND CAST('$fecha_final' AS DATE)
                              AND activo = '1'
                            ) AS Ordaz,
                            (
                              SELECT
                                SUM($bd[$i])
                              FROM
                                efectivos
                              WHERE
                                id_sucursal = '2'
                              AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE)
                              AND CAST('$fecha_final' AS DATE)
                              AND activo = '1'
                            ) AS Arboledas,
                            (
                              SELECT
                                SUM($bd[$i])
                              FROM
                                efectivos
                              WHERE
                                id_sucursal = '3'
                              AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE)
                              AND CAST('$fecha_final' AS DATE)
                              AND activo = '1'
                            ) AS Villegas,
                            (
                              SELECT
                                SUM($bd[$i])
                              FROM
                                efectivos
                              WHERE
                                id_sucursal = '4'
                              AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE)
                              AND CAST('$fecha_final' AS DATE)
                              AND activo = '1'
                            ) AS Allende
                          FROM
                            efectivos
                        ) AS tabla";

        $consulta = mysqli_query($conexion, $cadena);
        $row = mysqli_fetch_array($consulta);

        if ($row[0] == ""){ $row[0] = "0.00";}
        if ($row[1] == ""){ $row[1] = "0.00";}
        if ($row[2] == ""){ $row[2] = "0.00";}
        if ($row[3] == ""){ $row[3] = "0.00";}

        $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('B'.$excel[$i], $row[0])
              ->setCellValue('C'.$excel[$i], $row[1])
              ->setCellValue('D'.$excel[$i], $row[2])
              ->setCellValue('E'.$excel[$i], $row[3]);

        if ($i == 6 || $i == 7 || $i == 15 || $i == 22){
          $total_general_do += $row[0];
          $total_general_ar += $row[1];
          $total_general_vi += $row[2];
          $total_general_al += $row[3];
        }
      }

        $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A4','Efectivos')
              ->setCellValue('B4','Diaz Ordaz')
              ->setCellValue('C4','Arboledas')
              ->setCellValue('D4','Villegas')
              ->setCellValue('E4','Allende')
              ->setCellValue('B2',$fecha_ini)
              ->setCellValue('E2',$fecha_fin)
              ->setCellValue('A34','Total General:')
              ->setCellValue('B34',$total_general_do)
              ->setCellValue('C34',$total_general_ar)
              ->setCellValue('D34',$total_general_vi)
              ->setCellValue('E34',$total_general_al);

        for ($i=5; $i <= 34 ; $i++) { 
          $objPHPExcel->getActiveSheet()->getStyle("B".$i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        }
        for ($i=5; $i <= 34 ; $i++) { 
          $objPHPExcel->getActiveSheet()->getStyle("C".$i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        }
        for ($i=5; $i <= 34 ; $i++) { 
          $objPHPExcel->getActiveSheet()->getStyle("D".$i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        }
        for ($i=5; $i <= 34 ; $i++) { 
          $objPHPExcel->getActiveSheet()->getStyle("E".$i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        }


/////////////////////////////////DO/////////////////////////////////////////////////////
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A37', 'Diaz Ordaz');
        $celda_do = 38;
        $otros_do = mysqli_query($conexion,"SELECT concepto, cantidad FROM otros WHERE id_sucursal = '1' AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE) AND CAST('$fecha_final' AS DATE) AND activo = '1'"); //DO

        $cadena_suma_do = mysqli_query($conexion,"SELECT SUM(cantidad) FROM otros WHERE id_sucursal = '1' AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE) AND CAST('$fecha_final' AS DATE) AND activo = '1'");

        $row_suma_do = mysqli_fetch_array($cadena_suma_do);

        while ($row_otros_do = mysqli_fetch_array($otros_do)) {
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A'.$celda_do, $row_otros_do[0].':')
              ->setCellValue('B'.$celda_do, $row_otros_do[1]);

          $objPHPExcel->getActiveSheet()->getStyle("B".$celda_do)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

          $celda_do ++;
        }

        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$celda_do,'Total')
          ->setCellValue('B'.$celda_do,$row_suma_do[0]);

        $objPHPExcel->getActiveSheet()->getStyle("B".$celda_do)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

//////////////////////////////ARBOLEDAS//////////////////////////////////////
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('C37', 'Arboledas');
        $celda_ar = 38;
        $otros_ar = mysqli_query($conexion,"SELECT concepto, cantidad FROM otros WHERE id_sucursal = '2' AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE) AND CAST('$fecha_final' AS DATE) AND activo = '1'"); //AR

        $cadena_suma_ar = mysqli_query($conexion,"SELECT SUM(cantidad) FROM otros WHERE id_sucursal = '2' AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE) AND CAST('$fecha_final' AS DATE) AND activo = '1'");
        $row_suma_ar = mysqli_fetch_array($cadena_suma_ar);

        while ($row_otros_ar = mysqli_fetch_array($otros_ar)) {
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('C'.$celda_ar, $row_otros_ar[0].':')
              ->setCellValue('D'.$celda_ar, $row_otros_ar[1]);

          $objPHPExcel->getActiveSheet()->getStyle("D".$celda_ar)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

          $celda_ar ++;
        }

        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('C'.$celda_ar,'Total')
          ->setCellValue('D'.$celda_ar,$row_suma_ar[0]);

        $objPHPExcel->getActiveSheet()->getStyle("D".$celda_ar)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

//////////////////////////////VILLEGAS//////////////////////////////////////
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('E37', 'Villegas');
        $celda_vi = 38;
        $otros_vi = mysqli_query($conexion,"SELECT concepto, cantidad FROM otros WHERE id_sucursal = '3' AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE) AND CAST('$fecha_final' AS DATE) AND activo = '1'"); //AR

        $cadena_suma_vi = mysqli_query($conexion,"SELECT SUM(cantidad) FROM otros WHERE id_sucursal = '3' AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE) AND CAST('$fecha_final' AS DATE) AND activo = '1'");
        $row_suma_vi = mysqli_fetch_array($cadena_suma_vi);

        while ($row_otros_vi = mysqli_fetch_array($otros_vi)) {
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('E'.$celda_vi, $row_otros_vi[0].':')
              ->setCellValue('F'.$celda_vi, $row_otros_vi[1]);

          $objPHPExcel->getActiveSheet()->getStyle("F".$celda_vi)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

          $celda_vi ++;
        }

        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('E'.$celda_vi,'Total')
          ->setCellValue('F'.$celda_vi,$row_suma_vi[0]);

        $objPHPExcel->getActiveSheet()->getStyle("F".$celda_vi)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");        

//////////////////////////////Allende//////////////////////////////////////
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('G37', 'Allende');
        $celda_all = 38;
        $otros_all = mysqli_query($conexion,"SELECT concepto, cantidad FROM otros WHERE id_sucursal = '4' AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE) AND CAST('$fecha_final' AS DATE) AND activo = '1'"); //AR

        $cadena_suma_all = mysqli_query($conexion,"SELECT SUM(cantidad) FROM otros WHERE id_sucursal = '4' AND fecha_creacion BETWEEN CAST('$fecha_inicio' AS DATE) AND CAST('$fecha_final' AS DATE) AND activo = '1'");
        $row_suma_all = mysqli_fetch_array($cadena_suma_all);

        while ($row_otros_all = mysqli_fetch_array($otros_all)) {
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('G'.$celda_all, $row_otros_all[0].':')
              ->setCellValue('H'.$celda_all, $row_otros_all[1]);

          $objPHPExcel->getActiveSheet()->getStyle("H".$celda_all)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

          $celda_all ++;
        }

        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('G'.$celda_all,'Total')
          ->setCellValue('H'.$celda_all,$row_suma_all[0]);

        $objPHPExcel->getActiveSheet()->getStyle("H".$celda_all)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");                

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

       $estilo_derecha = array( 
              'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
              ),
              'font' => array(
                 'name'      => 'Arial',
                 'size'      => '11',
                 'bold'      => true,                          
                 'color'     => array(
                     'rgb' => '#000000'
                 )
             ));

        for($i = 'A'; $i <= 'H'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)      
                ->getColumnDimension($i)->setAutoSize(TRUE);
        }

        for ($i=1; $i <= 4 ; $i++) { 
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->applyFromArray($estiloTituloColumnas);
        }

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1'); //Combinar celdas
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2'); //Combinar celdas
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:F2'); //Combinar celdas
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A36:H36'); //Combinar celdas
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A15:H15'); //Combinar celdas
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A25:H25'); //Combinar celdas

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A37:B37'); //DO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C37:D37'); //AR
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E37:F37'); //VI
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G37:H37'); //VI

        /////////////////////////////////////DO///////////////////////
        $objPHPExcel->getActiveSheet()->getStyle('A'.$celda_do)->applyFromArray($estilo_derecha);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$celda_do)->applyFromArray($estilo_derecha);

        /////////////////////////////////////AR///////////////////////
        $objPHPExcel->getActiveSheet()->getStyle('C'.$celda_ar)->applyFromArray($estilo_derecha);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$celda_ar)->applyFromArray($estilo_derecha);

        /////////////////////////////////////VI///////////////////////
        $objPHPExcel->getActiveSheet()->getStyle('E'.$celda_vi)->applyFromArray($estilo_derecha);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$celda_vi)->applyFromArray($estilo_derecha);

        /////////////////////////////////////ALL///////////////////////
        $objPHPExcel->getActiveSheet()->getStyle('G'.$celda_all)->applyFromArray($estilo_derecha);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$celda_all)->applyFromArray($estilo_derecha);

        $objPHPExcel->getActiveSheet()->getStyle('A12')->applyFromArray($estiloTituloColumnas);   
        $objPHPExcel->getActiveSheet()->getStyle('A15')->applyFromArray($estiloTituloColumnas);   
        $objPHPExcel->getActiveSheet()->getStyle('A34:E34')->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getStyle('A25')->applyFromArray($estiloTituloColumnas);

        $objPHPExcel->getActiveSheet()->getStyle('A36')->applyFromArray($estiloTituloColumnas); //OTROS
        
        $objPHPExcel->getActiveSheet()->getStyle('A37')->applyFromArray($estiloTituloColumnas); //DO
        $objPHPExcel->getActiveSheet()->getStyle('C37')->applyFromArray($estiloTituloColumnas); //AR
        $objPHPExcel->getActiveSheet()->getStyle('E37')->applyFromArray($estiloTituloColumnas); //VI
        $objPHPExcel->getActiveSheet()->getStyle('G37')->applyFromArray($estiloTituloColumnas); //ALL

        $objPHPExcel->getActiveSheet()->getStyle('A11:E11')->applyFromArray($estilo_derecha);  

        $objPHPExcel->getActiveSheet()->getStyle('A23:E23')->applyFromArray($estilo_derecha);

        $objPHPExcel->getActiveSheet()->getStyle('A32:E32')->applyFromArray($estilo_derecha);

        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle('Reporte Faltantes');

        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);

        // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte_Efectivo.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
?>