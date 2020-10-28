<?php
date_default_timezone_set('America/Monterrey');
include '../global_settings/conexion.php';

$folio = $_GET['folio'];

$consulta = "SELECT
              CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno)As NombreCompleto,
              sucursales.nombre,
              DATE_FORMAT(efectivos.fecha, '%d/%m/%Y'),
              efectivos.efectivo,
              efectivos.complemento,
              efectivos.cheques_serfin,
              efectivos.cheques_locales,
              efectivos.tarjetas_credito,
              efectivos.t_debito,
              efectivos.t_prepago,
              efectivos.t_accor,
              efectivos.t_ecovale,
              efectivos.t_efectivale,
              efectivos.t_sivale,
              efectivos.t_tiendapass,
              efectivos.total_t,
              efectivos.b_prest_mex,
              efectivos.b_prest_uni,
              efectivos.b_accor,
              efectivos.b_efectivale,
              efectivos.b_mision_esp,
              efectivos.b_creditos,
              efectivos.b_total,
              efectivos.hora,
              efectivos.efectivo1,
              efectivos.efectivo2,
              efectivos.id_sucursal,
              efectivos.fecha
            FROM
              efectivos
            INNER JOIN usuarios ON usuarios.id = efectivos.id_usuario
            INNER JOIN personas ON personas.id = usuarios.id_persona
            INNER JOIN sucursales ON sucursales.id = personas.id_sede
            WHERE
              efectivos.folio = '$folio'";
$resultado = $conexion->query($consulta);

$consulta1 = "SELECT concepto,cantidad FROM otros WHERE folio = '$folio'";
$resultado1 = $conexion->query($consulta1);

$fila = $resultado->fetch_array();

$fecha = $fila[2];

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
                           ->setTitle("Reporte Efectivos")
                           ->setSubject("Reporte Efectivos")
                           ->setDescription("Reporte Efectivos")
                           ->setKeywords("Reporte Efectivos")
                           ->setCategory("Reporte Efectivos");

      $titulosColumnas = array('Sucursal:','Usuario:','Fecha:','Efectivo:','Complemento:','Cheques Serfin:','Cheques Locales:','Tarjetas de Credito:','Tarjetas Varias','Debito:','Prepago:','ACCOR:','Ecovale:','Efectivale:','Si Vale:','Tienda PASS:','Total:','Bonos','Prestaciones Mexicanas:','Prestaciones Universales:','ACCOR:','Efectivale:','La Mision Especial:','Creditos:','Total Bonos:','Otros');


      // Se agregan los titulos del reporte
      $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('A1',  $titulosColumnas[0]) //Sucursal
                  ->setCellValue('A2',  $titulosColumnas[1]) //Usuario
                  ->setCellValue('A3',  $titulosColumnas[2])
                  ->setCellValue('A5',  $titulosColumnas[3])
                  ->setCellValue('A6',  'Efectivo 2:')
                  ->setCellValue('A7',  'Efectivo 3:')
                  ->setCellValue('A8',  $titulosColumnas[4])
                  ->setCellValue('A9',  $titulosColumnas[5])
                  ->setCellValue('A10',  $titulosColumnas[6])
                  ->setCellValue('A11',  'Total:')
                  ->setCellValue('A13',  $titulosColumnas[7])
                  ->setCellValue('A15',  $titulosColumnas[8])
                  ->setCellValue('A16',  $titulosColumnas[9])
                  ->setCellValue('A17',  $titulosColumnas[10])
                  ->setCellValue('A18',  $titulosColumnas[11])
                  ->setCellValue('A19',  $titulosColumnas[12])
                  ->setCellValue('A20',  $titulosColumnas[13])
                  ->setCellValue('A21',  $titulosColumnas[14])
                  ->setCellValue('A22',  $titulosColumnas[15])
                  ->setCellValue('A23',  $titulosColumnas[16])
                  ->setCellValue('A25',  $titulosColumnas[17])
                  ->setCellValue('A26',  $titulosColumnas[18])
                  ->setCellValue('A27',  $titulosColumnas[19])
                  ->setCellValue('A28',  $titulosColumnas[20])
                  ->setCellValue('A29',  $titulosColumnas[21])
                  ->setCellValue('A30',  $titulosColumnas[22])
                  ->setCellValue('A31',  $titulosColumnas[23])
                  ->setCellValue('A32',  $titulosColumnas[24])
                  ->setCellValue('A34',  $titulosColumnas[25]);

            $suma_efectivos = 0;
            $suma_efectivos = $fila[3] + $fila[4] + $fila[5] + $fila[6] + $fila[24] +$fila[25];
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B1',$fila[1]) //Sucursal
                ->setCellValue('B2',$fila[0]) //Usuario
                ->setCellValue('B3',$fecha) //Fecha
                ->setCellValue('B5',$fila[3]) //Efectivo
                ->setCellValue('B6',$fila[24]) //Efectivo1
                ->setCellValue('B7',$fila[25]) //Efectivo2
                ->setCellValue('B8',$fila[4]) //Complemento
                ->setCellValue('B9',$fila[5]) //Cheques_ser 
                ->setCellValue('B10',$fila[6]) //Cheques_locales
                ->setCellValue('B11',$suma_efectivos) //Formula
                ->setCellValue('B13',$fila[7]) //Tarjetas_credito
                ->setCellValue('B15') //Tarjetas_varias
                ->setCellValue('B16',$fila[8]) // Debito
                ->setCellValue('B17',$fila[9]) //Prepago
                ->setCellValue('B18',$fila[10]) //Accor
                ->setCellValue('B19',$fila[11]) //Ecovale
                ->setCellValue('B20',$fila[12]) //Efectivale
                ->setCellValue('B21',$fila[13]) //Sivale
                ->setCellValue('B22',$fila[14]) //TIenda PASS
                ->setCellValue('B23',$fila[15]) //Total
                ->setCellValue('B25') //Bonos
                ->setCellValue('B26',$fila[16]) //Prestaciones_Mex
                ->setCellValue('B27',$fila[17]) //Prestaciones_Uni
                ->setCellValue('B28',$fila[18]) //Accor
                ->setCellValue('B29',$fila[19]) //Efectivale
                ->setCellValue('B30',$fila[20]) //Mision_especial
                ->setCellValue('B31',$fila[21]) //Creditos
                ->setCellValue('B32',$fila[22]) //Total Bonos
                ->setCellValue('B34'); //Otros

            $consulta3 = "SELECT abono FROM abonos WHERE id_sucursal = '$fila[26]' AND fecha = '$fila[27]'";
            $resultado3 = $conexion->query($consulta3);
            $celda_abonos = 0;

            $celda = 35;
            while($row_otros = mysqli_fetch_array($resultado1))
            {
              // $suma_otros += $row_otros[1]; 
               $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('A'.$celda,$row_otros[0].':')
                  ->setCellValue('B'.$celda,$row_otros[1]); //Sucursal
                $objPHPExcel->getActiveSheet()->getStyle("B".$celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $celda ++;
            }
            $celda_abonos = $celda + 1;
            while ($row_abonos = mysqli_fetch_array($resultado3)) {
              $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('A'.$celda_abonos,'Abono a Prestamo:')
                  ->setCellValue('B'.$celda_abonos,$row_abonos[0]); //Sucursal
              $objPHPExcel->getActiveSheet()->getStyle("B".$celda_abonos)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
              $celda_abonos ++;
            }
            for ($i=5; $i <= 33 ; $i++) { 
              $objPHPExcel->getActiveSheet()->getStyle("B".$i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
            }
            
            $celda_general = 0;
            $total_general = 0;
            $total_general = $suma_efectivos + $fila[15] + $fila[22] + $fila[7];

            $celda_general = $celda_abonos + 2;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$celda_general,'Total General :');

            $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('B'.$celda_general,$total_general);

            $objPHPExcel->getActiveSheet()->getStyle("B".$celda_general)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

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

        for($i = 'A'; $i <= 'B'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)			
                ->getColumnDimension($i)->setAutoSize(TRUE);
        }

        for ($i=1; $i <= 3 ; $i++) { 
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':B'.$i)->applyFromArray($estiloTituloColumnas);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A15')->applyFromArray($estiloTituloColumnas);   
        $objPHPExcel->getActiveSheet()->getStyle('A25')->applyFromArray($estiloTituloColumnas);   
        $objPHPExcel->getActiveSheet()->getStyle('A34')->applyFromArray($estiloTituloColumnas);

        $objPHPExcel->getActiveSheet()->getStyle('A23:B23')->applyFromArray($estilo_derecha);  
        $objPHPExcel->getActiveSheet()->getStyle('A11:B11')->applyFromArray($estilo_derecha);  
        $objPHPExcel->getActiveSheet()->getStyle('A32:B32')->applyFromArray($estilo_derecha);  

        $objPHPExcel->getActiveSheet()->getStyle('A'.$celda_general.':B'.$celda_general)->applyFromArray($estilo_derecha);  

        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle('Reporte Efectivos');

        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);

        // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte_Efectivos.xlsx"');
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