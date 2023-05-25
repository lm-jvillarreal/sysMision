<?php
    include '../global_seguridad/verificar_sesion.php';
    date_default_timezone_set('America/Monterrey');
    $hora  =date ("h:i:s");
    $fecha =date("Y-m-d");

    $encuesta       = $_POST['encuesta'];
    $fecha1         = $_POST['fecha1'];
    $fecha2         = $_POST['fecha2'];
    $filtro         = $_POST['filtro'];
    $filtro1        = $_POST['filtro1'];
    $filtro3         = $_POST['filtro2'];
    $filtro_general = "";
    $titulo         = "";
    $cuerpo         = "";
    $tabla          = "";
    $filtro2        = "";
    $button         = "";
    $filtrosucdep= "";

    function porcentaje($total, $parte, $redondear = 2) {
      if($total != 0){
        return round($parte / $total * 100, $redondear);
      }
      return 0;
    }

    if($filtro == 0){
      $cadena_principal = mysqli_query($conexion,"SELECT id,tipo,pregunta FROM n_preguntas WHERE folio = '$encuesta'");
      while ($row_pregunta = mysqli_fetch_array($cadena_principal)) {
        if($row_pregunta[1] == 1){
          $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
          $titulo .="<th width='5%'><center>Cantidad de Encuestados</center></th>";
          $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                              FROM n_resultados
                                              INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                              WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                              AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
          $cantidad1 = mysqli_num_rows($cadena4);
          $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

          $cadena5 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                              FROM n_resultados
                                              INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                              WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                              AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                                            AND n_resultados.respuesta = 'Si'".$filtro_general);
          $cantidad_si = mysqli_num_rows($cadena5);
          $cantidad_si = ($cantidad_si == "")?0:$cantidad_si;
          $porcentaje1 = porcentaje($cantidad1,$cantidad_si,2).'%';

          $titulo .= "<th><center>SI</center></th>";
          $cuerpo .="<td><center><label>$porcentaje1</label> ($cantidad_si)</center></td>";

          $cadena6 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                              FROM n_resultados
                                              INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                              WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                              AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                                            AND n_resultados.respuesta = 'No'".$filtro_general);
          $cantidad_no = mysqli_num_rows($cadena6);

          $porcentaje2 = porcentaje($cantidad1,$cantidad_no,2).'%';

          $titulo .= "<th><center>NO</center></th>";
          $cuerpo .="<td><center><label>$porcentaje2</label> ($cantidad_no)</center></td>";

        }else if($row_pregunta[1] == 2){

          $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
          $titulo .="<th><center>Cantidad de Encuestados</center></th>";
          $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                              FROM n_resultados
                                              INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                              WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                              AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
          $cantidad1 = mysqli_num_rows($cadena4);
          $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

          $suma = 0;
          $promedio = 0;
          $cadena = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                              FROM n_resultados
                                              INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                              WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                              AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
          $cantidad_respuestas = mysqli_num_rows($cadena);
          while ($row = mysqli_fetch_array($cadena)) {
            $suma += $row[0];
          }
          $promedio = ($suma != 0)?$suma/$cantidad_respuestas:0;

          $titulo .= "<th><center>Promedio:</center></th>";
          $cuerpo .="<td><center><label>$promedio</label></center></td>";

        }else if($row_pregunta[1] == 3){

          $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
          
          $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                              FROM n_resultados
                                              INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                              WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                              AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
          $cantidad1 = mysqli_num_rows($cadena4);

          $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                              FROM n_resultados
                                              INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                              WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                              AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
          $titulo .= "<th><center>Respuestas</center></th>";
          while ($row_libre = mysqli_fetch_array($cadena4)) {
            $cuerpo .="<tr><td>$row_libre[0]</td><tr>";
          }

        }else if($row_pregunta[1] == 4){

          $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
          
          $titulo .="<th><center>Cantidad de Encuestados</center></th>";
          $cadena4 = mysqli_query($conexion,"SELECT respuesta
                                              FROM n_resultados
                                              WHERE id_pregunta = '$row_pregunta[0]'
                                              AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
          $cantidad1 = mysqli_num_rows($cadena4);
          $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

          while ($row_respuesta = mysqli_fetch_array($cadena2)) {

            $cadena3 = mysqli_query($conexion,"SELECT respuesta FROM n_resultados WHERE id_pregunta = '$row_pregunta[0]' AND respuesta = '$row_respuesta[0]' AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad = mysqli_num_rows($cadena3);
            $cantidad = ($cantidad == "")?0:$cantidad;

            $porcentaje = porcentaje($cantidad1,$cantidad,2).'%';

            $titulo .= "<th><center>$row_respuesta[1]</center></th>";
            $cuerpo .="<td><center><label>$porcentaje</label> ($cantidad)</center></td>";

          }
        }
        
        $tabla .= "<div class='table-responsive' style='font-size:15px'>
                      <span class='badge bg-yellow'>Pregunta : $row_pregunta[2]</span>
                      <table id='lista_preguntas' class='table table-striped table-bordered' cellspacing='0' width='100%' >
                        <thead>$titulo</thead>
                        <tbody>$cuerpo</tbody>
                      </table>
                    </div><hr>";
        $titulo = "";
        $cuerpo = "";
      }
      $button = "<button class='btn btn-danger' onclick='cambiar(1)'>La Mision</button>";
      echo $button.$tabla;
    }else if ($filtro == 1 && $filtro1 == 0){

      $cadena = mysqli_query($conexion,"SELECT id,codigo, nombre FROM sucursales_sql");

      while($row_cadena = mysqli_fetch_array($cadena)){
        $cadena_principal = mysqli_query($conexion,"SELECT id,tipo,pregunta FROM n_preguntas WHERE folio = '$encuesta'");
        while ($row_pregunta = mysqli_fetch_array($cadena_principal)) {
          if($row_pregunta[1] == 1){
            $filtro_general = "AND trabajadores_sql.codigo_centro LIKE '$row_cadena[1]%'";
            $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $titulo .="<th width='5%'><center>Cantidad de Encuestados</center></th>";
            $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad1 = mysqli_num_rows($cadena4);
            $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

            $cadena5 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                                              AND n_resultados.respuesta = 'Si'".$filtro_general);
            $cantidad_si = mysqli_num_rows($cadena5);
            $cantidad_si = ($cantidad_si == "")?0:$cantidad_si;
            $porcentaje1 = porcentaje($cantidad1,$cantidad_si,2).'%';

            $titulo .= "<th><center>SI</center></th>";
            $cuerpo .="<td><center><label>$porcentaje1</label> ($cantidad_si)</center></td>";

            $cadena6 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                                              AND n_resultados.respuesta = 'No'".$filtro_general);
            $cantidad_no = mysqli_num_rows($cadena6);

            $porcentaje2 = porcentaje($cantidad1,$cantidad_no,2).'%';

            $titulo .= "<th><center>NO</center></th>";
            $cuerpo .="<td><center><label>$porcentaje2</label> ($cantidad_no)</center></td>";

          }else if($row_pregunta[1] == 2){
            $filtro_general = "AND trabajadores_sql.codigo_centro LIKE '$row_cadena[1]%'";
            // $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $titulo .="<th><center>Cantidad de Encuestados</center></th>";
            $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad1 = mysqli_num_rows($cadena4);
            $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

            $suma     = 0;
            $promedio = 0;
            $cadena_p = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_respuestas = mysqli_num_rows($cadena_p);
            while ($row = mysqli_fetch_array($cadena_p)) {
              $suma += $row[0];
            }
            $promedio = ($suma != 0)?$suma/$cantidad_respuestas:0;

            $titulo .= "<th><center>Promedio:</center></th>";
            $cuerpo .="<td><center><label>$promedio</label></center></td>";

          }else if($row_pregunta[1] == 3){
            $filtro_general = "AND trabajadores_sql.codigo_centro LIKE '$row_cadena[1]%'";
            
            $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad1 = mysqli_num_rows($cadena4);

            $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $titulo .= "<th><center>Respuestas</center></th>";
            while ($row_libre = mysqli_fetch_array($cadena4)) {
              $cuerpo .="<tr><td>$row_libre[0]</td><tr>";
            }

          }else if($row_pregunta[1] == 4){
            $filtro_general = "AND trabajadores_sql.codigo_centro LIKE '$row_cadena[1]%'";

            $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            
            $titulo .="<th><center>Cantidad de Encuestados</center></th>";
            $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad1 = mysqli_num_rows($cadena4);
            $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

            while ($row_respuesta = mysqli_fetch_array($cadena2)) {

              $cadena3 = mysqli_query($conexion,"SELECT respuesta FROM n_resultados INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona WHERE id_pregunta = '$row_pregunta[0]' AND respuesta = '$row_respuesta[0]' AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad = mysqli_num_rows($cadena3);
              $cantidad = ($cantidad == "")?0:$cantidad;

              $porcentaje = porcentaje($cantidad1,$cantidad,2).'%';

              $titulo .= "<th><center>$row_respuesta[1]</center></th>";
              $cuerpo .="<td><center><label>$porcentaje</label> ($cantidad)</center></td>";

            }
          }
          $button = "<button class='btn btn-danger' onclick='cambiar($row_cadena[1])'>$row_cadena[2]</button>";
          $tabla .= "<div class='table-responsive' style='font-size:15px'>
                        <span class='badge bg-yellow'>Pregunta : $row_pregunta[2]</span>
                        <table id='lista_preguntas' class='table table-striped table-bordered' cellspacing='0' width='100%' >
                          <thead>$titulo</thead>
                          <tbody>$cuerpo</tbody>
                        </table>
                      </div><hr>";
          $titulo = "";
          $cuerpo = "";
        }
        
        echo $button.$tabla;
        $tabla = "";
      }
    }else if ($filtro == 1 && $filtro1 != 0 && $filtro3 == 0){
      $cadena = mysqli_query($conexion,"SELECT codigo, nombre FROM departamentos_sql GROUP BY nombre");
      
      while($row_cadena = mysqli_fetch_array($cadena)){
        $filtro2 = '0'.$filtro1.$row_cadena[0];
        $cadena_principal = mysqli_query($conexion,"SELECT id,tipo,pregunta FROM n_preguntas WHERE folio = '$encuesta'");
        while ($row_pregunta = mysqli_fetch_array($cadena_principal)) {
          if($row_pregunta[1] == 1){
            $filtro_general = "AND trabajadores_sql.codigo_centro LIKE '$filtro2'";
            // $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta ,trabajadores_sql.codigo_centro
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){

              $titulo .="<th><center>Cantidad de Encuestados</center></th>";
              $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad1 = mysqli_num_rows($cadena4);
              $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

              $cadena5 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                                              AND n_resultados.respuesta = 'Si'".$filtro_general);
              $cantidad_si = mysqli_num_rows($cadena5);
              $cantidad_si = ($cantidad_si == "")?0:$cantidad_si;
              $porcentaje1 = porcentaje($cantidad1,$cantidad_si,2).'%';

              $titulo .= "<th><center>SI</center></th>";
              $cuerpo .="<td><center><label>$porcentaje1</label> ($cantidad_si)</center></td>";
              $cadena6 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                                              AND n_resultados.respuesta = 'No'".$filtro_general);
              $cantidad_no = mysqli_num_rows($cadena6);

              $porcentaje2 = porcentaje($cantidad1,$cantidad_no,2).'%';

              $titulo .= "<th><center>NO</center></th>";
              $cuerpo .="<td><center><label>$porcentaje2</label> ($cantidad_no)</center></td>";
            } 
          }else if($row_pregunta[1] == 2){
            $filtro_general = "AND trabajadores_sql.codigo_centro LIKE '$filtro2'";

            // $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta ,trabajadores_sql.codigo_centro
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){
              $titulo .="<th><center>Cantidad de Encuestados</center></th>";
              $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta ,trabajadores_sql.codigo_centro
                                                  FROM n_resultados
                                                  INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                  WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                  AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad1 = mysqli_num_rows($cadena4);
              $cuerpo .="<td><center><label>$cantidad1</label></center></td>";
              
              $suma     = 0;
              $promedio = 0;

              while ($row_respuesta = mysqli_fetch_array($cadena4)) {
                $cadena_s = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
                $cantidad_respuestas = mysqli_num_rows($cadena_s);
                while ($row_s = mysqli_fetch_array($cadena_s)) {
                  $suma += $row_s[0];
                }
                $promedio = ($suma != 0)?$suma/$cantidad_respuestas:0;

                $titulo .= "<th><center>Promedio:</center></th>";
                $cuerpo .="<td><center><label>$promedio</label></center></td>";
              }
            } 

          }else if($row_pregunta[1] == 3){
            $filtro_general = "AND trabajadores_sql.codigo_centro LIKE '$filtro2'";

            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta ,trabajadores_sql.codigo_centro
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){

              while ($row_respuesta = mysqli_fetch_array($cadena_ul)) {

                $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
                $titulo .= "<th><center>Respuestas</center></th>";
                while ($row_libre = mysqli_fetch_array($cadena4)) {
                  $cuerpo .="<tr><td>$row_libre[0]</td><tr>";
                }

              }
            }
          }else if($row_pregunta[1] == 4){
            $filtro_general = "AND trabajadores_sql.codigo_centro LIKE '$filtro2'";

            $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta ,trabajadores_sql.codigo_centro
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){
              $titulo .="<th><center>Cantidad de Encuestados</center></th>";
              $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta ,trabajadores_sql.codigo_centro
                                                  FROM n_resultados
                                                  INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                  WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                  AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad1 = mysqli_num_rows($cadena4);
              $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

              while ($row_respuesta = mysqli_fetch_array($cadena2)) {

                $cadena3 = mysqli_query($conexion,"SELECT respuesta FROM n_resultados INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona WHERE id_pregunta = '$row_pregunta[0]' AND respuesta = '$row_respuesta[0]' AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
                $cantidad = mysqli_num_rows($cadena3);
                $cantidad = ($cantidad == "")?0:$cantidad;

                $porcentaje = porcentaje($cantidad1,$cantidad,2).'%';

                $titulo .= "<th><center>$row_respuesta[1]</center></th>";
                $cuerpo .="<td><center><label>$porcentaje</label> ($cantidad)</center></td>";

              }
            }            
          }

          if($cantidad_ul != 0){
            $button = "<button class='btn btn-danger' onclick='cambiar($row_cadena[0])'>$row_cadena[1]</button>";
            $tabla .= "<div class='table-responsive' style='font-size:15px'>
                            <span class='badge bg-yellow'>Pregunta : $row_pregunta[2]</span>
                            <table id='lista_preguntas' class='table table-striped table-bordered' cellspacing='0' width='100%' >
                              <thead>$titulo</thead>
                              <tbody>$cuerpo</tbody>
                            </table>
                          </div><hr>";
              $titulo = "";
              $cuerpo = "";
          }else{
            $button = "";
          }
          
        }
        if($cantidad_ul != 0){
          echo $button.$tabla;
          $tabla = "";
            }else{

            }
        
        
      }
    }else{
      $filtro3 = str_pad($filtro3, 2, "0", STR_PAD_LEFT);
      $filtrosucdep = '0'.$filtro1.$filtro3;
      $cadena = mysqli_query($conexion,"SELECT codigo,nombre_completo, codigo_centro
            FROM trabajadores_sql WHERE codigo_centro LIKE '$filtrosucdep'");
      
      while($row_cadena = mysqli_fetch_array($cadena)){
        // $filtro2 = '0'.$filtro1.$row_cadena[0];
        $cadena_principal = mysqli_query($conexion,"SELECT id,tipo,pregunta FROM n_preguntas WHERE folio = '$encuesta'");
        while ($row_pregunta = mysqli_fetch_array($cadena_principal)) {
          if($row_pregunta[1] == 1){
            $filtro_general = "AND n_resultados.id_persona = '$row_cadena[0]'";
            // $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta ,trabajadores_sql.codigo_centro
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){
              $titulo .="<th><center>Cantidad de Encuestados</center></th>";
              $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad1 = mysqli_num_rows($cadena4);
              $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

              $cadena5 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                                              AND n_resultados.respuesta = 'Si'".$filtro_general);
              $cantidad_si = mysqli_num_rows($cadena5);
              $cantidad_si = ($cantidad_si == "")?0:$cantidad_si;
              $porcentaje1 = porcentaje($cantidad1,$cantidad_si,2).'%';

              $titulo .= "<th><center>SI</center></th>";
              $cuerpo .="<td><center><label>$porcentaje1</label> ($cantidad_si)</center></td>";

              $cadena6 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                                              AND n_resultados.respuesta = 'No'".$filtro_general);
              $cantidad_no = mysqli_num_rows($cadena6);

              $porcentaje2 = porcentaje($cantidad1,$cantidad_no,2).'%';

              $titulo .= "<th><center>NO</center></th>";
              $cuerpo .="<td><center><label>$porcentaje2</label> ($cantidad_no)</center></td>";

            }            
          }else if($row_pregunta[1] == 2){
            $filtro_general = "AND n_resultados.id_persona = '$row_cadena[0]'";
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta ,trabajadores_sql.codigo_centro
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){
              $titulo .="<th><center>Cantidad de Encuestados</center></th>";
              $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                  FROM n_resultados
                                                  INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                  WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                  AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad1 = mysqli_num_rows($cadena4);
              $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

              $suma = 0;
              $promedio = 0;
              $cadena = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                  FROM n_resultados
                                                  INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                  WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                  AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad_respuestas = mysqli_num_rows($cadena);
              while ($row = mysqli_fetch_array($cadena)) {
                $suma += $row[0];
              }
              $promedio = ($suma != 0)?$suma/$cantidad_respuestas:0;

              $titulo .= "<th><center>Promedio:</center></th>";
              $cuerpo .="<td><center><label>$promedio</label></center></td>";
            }

          }else if($row_pregunta[1] == 3){
            $filtro_general = "AND n_resultados.id_persona = '$row_cadena[0]'";
            
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta ,trabajadores_sql.codigo_centro
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){
              // $titulo .="<th><center>Cantidad de Encuestados</center></th>";
              // $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta ,trabajadores_sql.codigo_centro
              //                                     FROM n_resultados
              //                                     INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
              //                                     WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
              //                                     AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              // $cantidad1 = mysqli_num_rows($cadena4);
              // $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

              // while ($row_respuesta = mysqli_fetch_array($cadena2)) {

                $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
                $titulo .= "<th><center>Respuestas</center></th>";
                while ($row_libre = mysqli_fetch_array($cadena4)) {
                  $cuerpo .="<tr><td>$row_libre[0]</td><tr>";
                }

              //}
            }

          }else if($row_pregunta[1] == 4){
            $filtro_general = "AND n_resultados.id_persona = '$row_cadena[0]'";

            $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta ,trabajadores_sql.codigo_centro
                                                FROM n_resultados
                                                INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){
              $titulo .="<th><center>Cantidad de Encuestados</center></th>";
              $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta ,trabajadores_sql.codigo_centro
                                                  FROM n_resultados
                                                  INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona
                                                  WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                  AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad1 = mysqli_num_rows($cadena4);
              $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

              while ($row_respuesta = mysqli_fetch_array($cadena2)) {

                $cadena3 = mysqli_query($conexion,"SELECT respuesta FROM n_resultados INNER JOIN trabajadores_sql ON trabajadores_sql.codigo = n_resultados.id_persona WHERE id_pregunta = '$row_pregunta[0]' AND respuesta = '$row_respuesta[0]' AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
                $cantidad = mysqli_num_rows($cadena3);
                $cantidad = ($cantidad == "")?0:$cantidad;

                $porcentaje = porcentaje($cantidad1,$cantidad,2).'%';

                $titulo .= "<th><center>$row_respuesta[1]</center></th>";
                $cuerpo .="<td><center><label>$porcentaje</label> ($cantidad)</center></td>";

              }
            }            
          }
          if($cantidad_ul != 0){
            $button = "<button class='btn btn-danger'>$row_cadena[1]</button>";
            $tabla .= "<div class='table-responsive' style='font-size:15px'>
                            <span class='badge bg-yellow'>Pregunta : $row_pregunta[2]</span>
                            <table id='lista_preguntas' class='table table-striped table-bordered' cellspacing='0' width='100%' >
                              <thead>$titulo</thead>
                              <tbody>$cuerpo</tbody>
                            </table>
                          </div><hr>";
              $titulo = "";
              $cuerpo = "";
          }else{
            $button = "";
          }
          
        }
        if($cantidad_ul != 0){
          echo $button.$tabla;
          $tabla = "";
        }
      }
    }
 ?>