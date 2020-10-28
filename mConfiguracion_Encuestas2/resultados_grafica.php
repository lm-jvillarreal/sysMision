<?php
    
    include '../global_seguridad/verificar_sesion.php';


    $cantidad    = 0;
    $json        = [];
    $i           = 1;

    $id_encuesta = $_POST['id_encuesta'];
    $fecha1      = $_POST['fecha1'];
    $fecha2      = $_POST['fecha2'];
    $pregunta    = $_POST['pregunta'];
    $filtro = ($pregunta != "")?" AND n_preguntas.id = '$pregunta'":"";

    if($pregunta != ""){
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
            
            $json[] = [(int)$i, (int)$cantidad];
            $cantidad = 0;
            $i ++;
        }
    }else{
        $cantidad = 0;
        $cadena = mysqli_query($conexion,"SELECT id,pregunta
                                            FROM n_preguntas
                                            WHERE tipo = '2'
                                            AND folio = '$id_encuesta'");
        while ($row = mysqli_fetch_array($cadena)) {

            $cadena2 = mysqli_query($conexion, "SELECT n_resultados.respuesta
                    FROM n_resultados
                    INNER JOIN n_preguntas ON n_preguntas.id = n_resultados.id_pregunta
                    AND n_preguntas.id = '$row[0]'
                    AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE)
                    AND CAST('$fecha2' AS DATE)");
            while ($row2 = mysqli_fetch_array($cadena2)) {
               $cantidad += $row2[0];
            }
            $json[] = [(string)$row[1], (int)$cantidad]; 
            $cantidad = 0;
        }
    }
    // echo $gasto;
    echo json_encode($json);
?>