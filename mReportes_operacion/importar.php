
    <?php
    //include'../configuracion/conexion_servidor.php';
    //include '../global_seguridad/verificar_sesion.php';
    
    extract($_POST);
    date_default_timezone_set("America/Monterrey");
    $fecha=date('Y-m-d');
    
    // $qry = "SELECT MAX(mapeo.id) FROM mapeo";
    // $exQry = mysqli_query($conexion, $qry);
    // $r = mysqli_fetch_row($exQry);
    $action = "upload";
    if ($action == "upload") {
        //cargamos el archivo al servidor con el mismo nombre
        //solo le agregue el sufijo bak_ 
        $archivo = $_FILES['excel']['name'];
        $tipo = $_FILES['excel']['type'];
        $destino = "bak_" . $archivo;
        if (copy($_FILES['excel']['tmp_name'], $destino)){
            //echo "Archivo Cargado Con Éxito";
        }
        else{
            echo "Error Al Cargar el Archivo";
        }
        if (file_exists("bak_" . $archivo)) {
            /** Clases necesarias */
            require_once('../plugins/PHPExcel/Classes/PHPExcel.php');
            require_once('../plugins/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php');
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
                $_DATOS_EXCEL[] = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
            }
        }
        //si por algo no cargo el archivo bak_ 
        else {
            echo "Necesitas primero importar el archivo";
        }
        $errores = 0;
        }
        $array  = json_encode($_DATOS_EXCEL);
        echo "$array";
        unlink($destino);
    ?>