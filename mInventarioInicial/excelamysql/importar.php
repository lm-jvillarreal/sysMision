<body>
    <?php
    include'../../global_settings/conexion_supsys.php';
    //include '../global_seguridad/verificar_sesion.php';
    
    extract($_POST);
    date_default_timezone_set("America/Monterrey");
    $action = "upload";
    $fecha=date('Y-m-d');
    $qry = "SELECT MAX(id) FROM existencias";
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
            for ($i = 2; $i <= $totalregistros; $i++) {
                $_DATOS_EXCEL[$i]['id'] = $r[0];
                $_DATOS_EXCEL[$i]['codigo'] = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
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
            $sql = "INSERT INTO detalle_existencia(id_existencia, codigo, cantidad) VALUES ('";
            foreach ($valor as $campo2 => $valor2) {
                $campo2 == "cantidad" ? $sql.= $valor2 . "');" : $sql.= $valor2 . "','";
            }
            echo $sql;
            $result = mysqli_query($conexion, $sql);
            if (!$result) {
                echo "Error al insertar registro " . $campo;
                $errores+=1;
            }
        }
        echo "<strong><center>ARCHIVO IMPORTADO CON EXITO, EN TOTAL $campo REGISTROS Y $errores ERRORES</center></strong>";
        //una vez terminado el proceso borramos el archivo que esta en el servidor el bak_
        unlink($destino);
    }
    ?>
</body>
</html>