<body>
    <?php
    include '../../global_settings/conexion.php';
    include '../../global_settings/conexion_oracle.php';
    //include '../../global_seguridad/verificar_sesion.php';
    //include'../configuracion/conexion.php';
    //include '../global_seguridad/verificar_sesion.php';
    
    extract($_POST);
    date_default_timezone_set("America/Monterrey");
    $fecha=date('Y-m-d');
    $action = "upload";
    $insert = "INSERT INTO inv_mapeo(id_area, id_sucursal, fecha, usuario, activo, mueble, zona, cara, completo, fecha_conteo, contador, supervisor, auditor, impreso) VALUES(15, 1, '$fecha',1, 0, 'Importado', 'Importado', 'Imp', 1, '$fecha', 3, 2, 2, 1)";
    $exInsert =mysqli_query($conexion, $insert);
    //echo "$insert";

    $qry = "SELECT MAX(inv_mapeo.id) FROM inv_mapeo";
    $exQry = mysqli_query($conexion, $qry);
    $r = mysqli_fetch_row($exQry);
    if ($action == "upload") {
        //cargamos el archivo al servidor con el mismo nombre
        //solo le agregue el sufijo bak_ 
        $archivo = $_FILES['excel']['name'];
        $tipo = $_FILES['excel']['type'];
        $destino = "bak_" . $archivo;
        if (copy($_FILES['excel']['tmp_name'], $destino)){
            echo "Archivo Cargado Con Éxito";
        }
        else{
            echo "Error Al Cargar el Archivo";
        }
        if (file_exists("bak_" . $archivo)) {
            /** Clases necesarias */
            require_once('Classes/PHPExcel.php');
            require_once('Classes/PHPExcel/Reader/Excel2007.php');
            // Cargando la hoja de cálculo
            $objReader = new PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader->load("bak_" . $archivo);
            $objFecha = new PHPExcel_Shared_Date();

            // Asignar hoja de excel activa
            $objPHPExcel->setActiveSheetIndex(0);
            //conectamos con la base de datos 
            // $cn = mysql_connect("localhost", "root", "sebastian") or die("ERROR EN LA CONEXION");
            // $db = mysql_select_db("supsys", $cn) or die("ERROR AL CONECTAR A LA BD");
            $totalregistros = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); 
            // Llenamos el arreglo con los datos  del archivo xlsx
            for ($i = 1; $i <= $totalregistros; $i++) {
                $_DATOS_EXCEL[$i]['estante'] = 1;
                $_DATOS_EXCEL[$i]['consecutivo_mueble'] = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
                
                //$cantidad = $_DATOS_EXCEL[$i]['cantidad'];
                $_DATOS_EXCEL[$i]['codigo_producto'] = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                $cod = $_DATOS_EXCEL[$i]['codigo_producto'];
                $_DATOS_EXCEL[$i]['fecha'] = $fecha;
                $_DATOS_EXCEL[$i]['id_mapeo'] = $r[0];
                $sql_o = "SELECT artc_descripcion FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$cod'";
                $st = oci_parse($conexion_central, $sql_o);
                oci_execute($st);
                $row = oci_fetch_row($st);
                $_DATOS_EXCEL[$i]['descripcion'] = $row[0];
                $_DATOS_EXCEL[$i]['cantidad'] = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                
            }
        }
        //si por algo no cargo el archivo bak_ 
        else {
            echo "Necesitas primero importar el archivo";
        }
        $errores = 0;
        //recorremos el arreglo multidimensional 
        //para ir recuperando los datos obtenidos
        //del excel e ir insertandolos en la BD
        foreach ($_DATOS_EXCEL as $campo => $valor) {
            $sql = "INSERT INTO inv_detalle_mapeo (estante, consecutivo_mueble, codigo_producto,fecha , id_mapeo, descripcion, c ) VALUES ('";
            foreach ($valor as $campo2 => $valor2) {
                $campo2 == "cantidad" ? $sql.= $valor2 . "');" : $sql.= $valor2 . "','";
            }
            echo $sql;
            $result = mysqli_query($conexion, $sql);
            // if (!$result) {
            //     echo "Error al insertar registro " . $campo;
            //     $errores+=1;
            // }
        }
        $in_sel = "INSERT INTO inv_captura(id_mapeo, id_detalle_mapeo, cod_producto, cantidad)
                    SELECT id_mapeo, id, codigo_producto, c FROM inv_detalle_mapeo WHERE id_mapeo = $r[0]";
            $exIn = mysqli_query($conexion, $in_sel);
        echo "<strong><center>ARCHIVO IMPORTADO CON EXITO, EN TOTAL $campo REGISTROS Y $errores ERRORES</center></strong>";
        //una vez terminado el proceso borramos el archivo que esta en el servidor el bak_
        unlink($destino);
    }
    ?>
</body>
</html>