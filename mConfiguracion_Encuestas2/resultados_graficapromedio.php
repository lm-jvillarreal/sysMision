<?php
    
    include '../global_seguridad/verificar_sesion.php';

    $id_encuesta = $_POST['id_encuesta'];
    $fecha1      = $_POST['fecha1'];
    $fecha2      = $_POST['fecha2'];
    $pregunta    = $_POST['pregunta'];
    $filtro = ($pregunta == "")?"":" AND n_preguntas.id = '$pregunta'";

    $cadena = "SELECT SUM(n_resultados.respuesta)
                FROM n_resultados
                INNER JOIN n_preguntas ON n_preguntas.id = n_resultados.id_pregunta
                WHERE n_preguntas.tipo = '2'
                AND n_resultados.folio_encuesta = '$id_encuesta'
                ".$filtro."
                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE)
                AND CAST('$fecha2' AS DATE)";
    $consulta = mysqli_query($conexion,$cadena);
    $row = mysqli_fetch_array($consulta);

    $cantidad_resultados = ($row[0] == "")?0:$row[0]; //SUMA

    $cadena = "SELECT id,pregunta
                FROM n_preguntas
                WHERE n_preguntas.tipo = '2'
                AND n_preguntas.folio = '$id_encuesta'
                ".$filtro."
                AND n_preguntas.fecha BETWEEN CAST('$fecha1' AS DATE)
                AND CAST('$fecha2' AS DATE)";
    $consulta2 = mysqli_query($conexion,$cadena);
    $cantidad  = mysqli_num_rows($consulta2);

    $cantidad = ($cantidad == "")?0:$cantidad;

    if($filtro != ""){
        $cantidad = 5;
    }

    $promedio = $cantidad_resultados/$cantidad;
    $array = array($cantidad_resultados,$cantidad,$promedio);
    echo json_encode($array);
?>