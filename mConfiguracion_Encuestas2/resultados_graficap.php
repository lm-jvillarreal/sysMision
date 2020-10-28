<?php
    
    include '../global_seguridad/verificar_sesion.php';

    $id_encuesta = $_POST['id_encuesta'];
    $fecha1      = $_POST['fecha1'];
    $fecha2      = $_POST['fecha2'];
    $pregunta    = $_POST['pregunta'];
    $filtro = ($pregunta != "")?" AND n_preguntas.id = '$pregunta'":"";

    $uno    = 0;
    $dos    = 0;
    $tres   = 0;
    $cuatro = 0;
    $cinco  = 0;
    $i= 0;

    while ($i <= 5) {

            $cadena = "SELECT n_resultados.respuesta
                        FROM n_resultados
                        INNER JOIN n_preguntas ON n_preguntas.id = n_resultados.id_pregunta
                        WHERE n_preguntas.tipo = '2'
                        AND n_resultados.respuesta = '$i'
                        ".$filtro." AND n_resultados.folio_encuesta = '$id_encuesta'
                        AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE)
                        AND CAST('$fecha2' AS DATE)";
            $cadena2 = mysqli_query($conexion,$cadena);
            $cantidad = mysqli_num_rows($cadena2);

            $cantidad = ($cantidad == "")?0:$cantidad;

            if($i == "1"){
                $uno = $cantidad;
            }else if($i == "2"){
                $dos = $cantidad;
            }else if($i == "3"){
                $tres = $cantidad;
            }else if($i == "4"){
                $cuatro = $cantidad;
            }else{
                $cinco = $cantidad;
            }
            
            $cantidad = 0;
            $i ++;
        }

    $array = array($uno,$dos,$tres,$cuatro,$cinco);
    echo json_encode($array);
?>