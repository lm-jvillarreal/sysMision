<?php

    include '../global_settings/consulta_sqlsrvr.php';
    include '../global_settings/conexion.php';

    $encuesta       = $_POST['encuesta'];
    $fecha1         = $_POST['fecha1'];
    $fecha2         = $_POST['fecha2'];
    $filtro         = $_POST['filtro'];
    $filtro1        = $_POST['filtro1'];
    $filtro3        = $_POST['filtro2'];
    //$sucur          = $_POST['sucur'];
    $sucur          = "DIAZ ORDAZ";
    $dept           = $_POST['dept'];
    $filtro_general = "";
    $titulo         = "";
    $cuerpo         = "";
    $tabla          = "";
    $filtro2        = "";
    $button         = "";

    function porcentaje($total, $parte, $redondear = 2) {
      if($total != 0){
        return round($parte / $total * 100, $redondear);
      }
      return 0;
    }

    if($filtro == 0){
      echo '<ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> La Mision</li>
      </ol>';
      $cadena_principal = mysqli_query($conexion,"SELECT id,tipo,pregunta FROM n_preguntas WHERE folio = '$encuesta'");
      while ($row_pregunta = mysqli_fetch_array($cadena_principal)) {
        if($row_pregunta[1] == 1){
          $filtro_general = "AND id_encuesta = '$encuesta'";
          $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
          $titulo .="<th width='5%'><center>Cantidad de Encuestados</center></th>";
          $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                              FROM n_resultados
                                              INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                              WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                              AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
          $cantidad1 = mysqli_num_rows($cadena4);
          $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

          $cadena5 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                              FROM n_resultados
                                              INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
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
                                              INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                              WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                              AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                                            AND n_resultados.respuesta = 'No'".$filtro_general);
          $cantidad_no = mysqli_num_rows($cadena6);

          $porcentaje2 = porcentaje($cantidad1,$cantidad_no,2).'%';

          $titulo .= "<th><center>NO</center></th>";
          $cuerpo .="<td><center><label>$porcentaje2</label> ($cantidad_no)</center></td>";

        }else if($row_pregunta[1] == 2){
          $filtro_general = "AND id_encuesta = '$encuesta'";
          $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
          $titulo .="<th><center>Cantidad de Encuestados</center></th>";
          $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                              FROM n_resultados
                                              INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                              WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                              AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
          $cantidad1 = mysqli_num_rows($cadena4);
          $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

          $suma = 0;
          $promedio = 0;
          $cadena = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                              FROM n_resultados
                                              INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
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
          $filtro_general = "AND id_encuesta = '$encuesta'";
          $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
          
          $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                              FROM n_resultados
                                              INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                              WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                              AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
          $cantidad1 = mysqli_num_rows($cadena4);

          $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                              FROM n_resultados
                                              INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
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
      echo '<ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> La Mision</li>
        <li>Sucursales</li>
      </ol>';

      // $cadena = mysqli_query($conexion,"SELECT id,codigo, nombre FROM sucursales_sql");
      //SELECT campo__14, campo__15 FROM clasificacion_empleados as clase 
					   //INNER JOIN empleados ON clase.codigo=empleados.codigo WHERE empleados.codigo = '$codigo'
					   //AND (
							//clase.empresa= 4 
							//OR clase.empresa= 7)
      $cadena = sqlsrv_query($conn,"SELECT campo__14 FROM clasificacion_empleados WHERE campo__14 != '' GROUP BY campo__14");
      //$cadena = sqlsrv_query($conn,"SELECT campo__14 FROM clasificacion_empleados WHERE campo__14 != '' GROUP BY campo__14");
      while ($row_cadena = sqlsrv_fetch_array( $cadena, SQLSRV_FETCH_ASSOC)) {
        $sucursal_rc = $row_cadena['campo__14'];
        if($sucursal_rc == "ADMINISTRACION"){
          continue;
        }
        $cadena_principal = mysqli_query($conexion,"SELECT id,tipo,pregunta FROM n_preguntas WHERE folio = '$encuesta'");
        while ($row_pregunta = mysqli_fetch_array($cadena_principal)) {
          if($row_pregunta[1] == 1){
            $filtro_general = "AND n_invitados.sucursal = '$sucursal_rc' AND id_encuesta = '$encuesta'";

            $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $titulo .="<th width='5%'><center>Cantidad de Encuestados</center></th>";
            $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad1 = mysqli_num_rows($cadena4);
            $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

            $cadena5 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
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
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                                              AND n_resultados.respuesta = 'No'".$filtro_general);
            $cantidad_no = mysqli_num_rows($cadena6);

            $porcentaje2 = porcentaje($cantidad1,$cantidad_no,2).'%';

            $titulo .= "<th><center>NO</center></th>";
            $cuerpo .="<td><center><label>$porcentaje2</label> ($cantidad_no)</center></td>";

          }else if($row_pregunta[1] == 2){
            $filtro_general = "AND n_invitados.sucursal = '$sucursal_rc' AND id_encuesta = '$encuesta'";
            // $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $titulo .="<th><center>Cantidad de Encuestados</center></th>";
            $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad1 = mysqli_num_rows($cadena4);
            $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

            $suma     = 0;
            $promedio = 0;
            $cadena_p = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
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
            $filtro_general = "AND n_invitados.sucursal = '$sucursal_rc' AND id_encuesta = '$encuesta'";
            
            $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad1 = mysqli_num_rows($cadena4);

            $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $titulo .= "<th><center>Respuestas</center></th>";
            while ($row_libre = mysqli_fetch_array($cadena4)) {
              $cuerpo .="<tr><td>$row_libre[0]</td><tr>";
            }

          }else if($row_pregunta[1] == 4){
            $filtro_general = "AND n_invitados.sucursal = '$sucursal_rc' AND id_encuesta = '$encuesta'";

            $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            
            $titulo .="<th><center>Cantidad de Encuestados</center></th>";
            $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad1 = mysqli_num_rows($cadena4);
            $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

            while ($row_respuesta = mysqli_fetch_array($cadena2)) {

              $cadena3 = mysqli_query($conexion,"SELECT respuesta FROM n_resultados INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona WHERE id_pregunta = '$row_pregunta[0]' AND respuesta = '$row_respuesta[0]' AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad = mysqli_num_rows($cadena3);
              $cantidad = ($cantidad == "")?0:$cantidad;

              $porcentaje = porcentaje($cantidad1,$cantidad,2).'%';

              $titulo .= "<th><center>$row_respuesta[1]</center></th>";
              $cuerpo .="<td><center><label>$porcentaje</label> ($cantidad)</center></td>";

            }
          }
          $button = "<button class=\"btn btn-danger\" onclick=\"cambiar(1,'$sucursal_rc')\" >$sucursal_rc</button>";
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
      echo '<ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> La Mision</a></li>
        <li>'.$sucur.'</li>
        <li>Departamentos</li>
      </ol>';
      // $cadena = mysqli_query($conexion,"SELECT codigo, nombre FROM departamentos_sql GROUP BY nombre");
      $cadena = sqlsrv_query($conn,"SELECT campo__15 FROM clasificacion_empleados WHERE campo__15 != '' GROUP BY campo__15");
      
      while ($row_cadena = sqlsrv_fetch_array( $cadena, SQLSRV_FETCH_ASSOC)) {
        $departamento_rc =  $row_cadena['campo__15'];
      // while($row_cadena = mysqli_fetch_array($cadena)){
        // $filtro2 = '0'.$filtro1.$row_cadena[0];
        $cadena_principal = mysqli_query($conexion,"SELECT id,tipo,pregunta FROM n_preguntas WHERE folio = '$encuesta'");
        while ($row_pregunta = mysqli_fetch_array($cadena_principal)) {
          if($row_pregunta[1] == 1){
            $filtro_general = "AND n_invitados.departamento = '$departamento_rc' AND n_invitados.sucursal = '$sucur' AND id_encuesta = '$encuesta'";
            // $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){

              $titulo .="<th><center>Cantidad de Encuestados</center></th>";
              $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad1 = mysqli_num_rows($cadena4);
              $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

              $cadena5 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
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
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                                              AND n_resultados.respuesta = 'No'".$filtro_general);
              $cantidad_no = mysqli_num_rows($cadena6);

              $porcentaje2 = porcentaje($cantidad1,$cantidad_no,2).'%';

              $titulo .= "<th><center>NO</center></th>";
              $cuerpo .="<td><center><label>$porcentaje2</label> ($cantidad_no)</center></td>";
            } 
          }else if($row_pregunta[1] == 2){
            $filtro_general = "AND n_invitados.departamento = '$departamento_rc' AND n_invitados.sucursal = '$sucur'  AND id_encuesta = '$encuesta'";

            // $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){
              $titulo .="<th><center>Cantidad de Encuestados</center></th>";
              $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                  FROM n_resultados
                                                  INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                  WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                  AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad1 = mysqli_num_rows($cadena4);
              $cuerpo .="<td><center><label>$cantidad1</label></center></td>";
              
              $suma     = 0;
              $promedio = 0;

              while ($row_respuesta = mysqli_fetch_array($cadena4)) {
                $cadena_s = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
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
            $filtro_general = "AND n_invitados.departamento = '$departamento_rc' AND n_invitados.sucursal = '$sucur'  AND id_encuesta = '$encuesta'";
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){

              while ($row_respuesta = mysqli_fetch_array($cadena_ul)) {

                $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
                $titulo .= "<th><center>Respuestas</center></th>";
                while ($row_libre = mysqli_fetch_array($cadena4)) {
                  $cuerpo .="<tr><td>$row_libre[0]</td><tr>";
                }

              }
            }
          }else if($row_pregunta[1] == 4){
            $filtro_general = "AND n_invitados.departamento = '$departamento_rc' AND n_invitados.sucursal = '$sucur' AND id_encuesta = '$encuesta'";

            $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta  = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){
              $titulo .="<th><center>Cantidad de Encuestados</center></th>";
              $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                  FROM n_resultados
                                                  INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                  WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                  AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad1 = mysqli_num_rows($cadena4);
              $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

              while ($row_respuesta = mysqli_fetch_array($cadena2)) {

                $cadena3 = mysqli_query($conexion,"SELECT respuesta FROM n_resultados INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona WHERE id_pregunta = '$row_pregunta[0]' AND respuesta = '$row_respuesta[0]' AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
                $cantidad = mysqli_num_rows($cadena3);
                $cantidad = ($cantidad == "")?0:$cantidad;

                $porcentaje = porcentaje($cantidad1,$cantidad,2).'%';

                $titulo .= "<th><center>$row_respuesta[1]</center></th>";
                $cuerpo .="<td><center><label>$porcentaje</label> ($cantidad)</center></td>";

              }
            }            
          }

          if($cantidad_ul != 0){
            $button = "<button class=\"btn btn-danger\" onclick=\"cambiar('1','$departamento_rc')\">$departamento_rc</button>";
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
      echo '<ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> La Mision</a></li>
        <li>'.$sucur.'</li>
        <li>'.$dept.'</li>
      </ol>';
      $cadena = mysqli_query($conexion,"SELECT codigo_trabajador FROM n_invitados WHERE sucursal = '$sucur' AND departamento = '$dept' AND id_encuesta = '$encuesta'");
      
      while($row_cadena = mysqli_fetch_array($cadena)){
        $cadena = sqlsrv_query($conn,"SELECT codigo, (cast(codigo as varchar) + ' - ' + nombre + ' ' + ap_paterno + ' ' + ap_materno) AS 'nombre' FROM empleados WHERE activo = 'S' AND codigo = '$row_cadena[0]'");
        $row_nt = sqlsrv_fetch_array( $cadena, SQLSRV_FETCH_ASSOC);
        $nombre_trabajador = $row_nt['nombre'];

        $cadena_principal = mysqli_query($conexion,"SELECT id,tipo,pregunta FROM n_preguntas WHERE folio = '$encuesta'");
        while ($row_pregunta = mysqli_fetch_array($cadena_principal)) {
          if($row_pregunta[1] == 1){
            $filtro_general = "AND n_resultados.id_persona = '$row_cadena[0]' AND id_encuesta = '$encuesta'";
            // $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){
              $titulo .="<th><center>Cantidad de Encuestados</center></th>";
              $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND id_encuesta = '$encuesta'".$filtro_general);
              $cantidad1 = mysqli_num_rows($cadena4);
              $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

              $cadena5 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                                              AND n_resultados.respuesta = 'Si' AND id_encuesta = '$encuesta'".$filtro_general);
              $cantidad_si = mysqli_num_rows($cadena5);
              $cantidad_si = ($cantidad_si == "")?0:$cantidad_si;
              $porcentaje1 = porcentaje($cantidad1,$cantidad_si,2).'%';

              $titulo .= "<th><center>SI</center></th>";
              $cuerpo .="<td><center><label>$porcentaje1</label> ($cantidad_si)</center></td>";

              $cadena6 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                                              AND n_resultados.respuesta = 'No' AND id_encuesta = '$encuesta'".$filtro_general);
              $cantidad_no = mysqli_num_rows($cadena6);

              $porcentaje2 = porcentaje($cantidad1,$cantidad_no,2).'%';

              $titulo .= "<th><center>NO</center></th>";
              $cuerpo .="<td><center><label>$porcentaje2</label> ($cantidad_no)</center></td>";

            }            
          }else if($row_pregunta[1] == 2){
            $filtro_general = "AND n_resultados.id_persona = '$row_cadena[0]' AND id_encuesta = '$encuesta'";
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){
              $titulo .="<th><center>Cantidad de Encuestados</center></th>";
              $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                  FROM n_resultados
                                                  INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                  WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                  AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad1 = mysqli_num_rows($cadena4);
              $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

              $suma = 0;
              $promedio = 0;
              $cadena = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                  FROM n_resultados
                                                  INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
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
            $filtro_general = "AND n_resultados.id_persona = '$row_cadena[0]' AND id_encuesta = '$encuesta'";
            
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
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
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
                $titulo .= "<th><center>Respuestas</center></th>";
                while ($row_libre = mysqli_fetch_array($cadena4)) {
                  $cuerpo .="<tr><td>$row_libre[0]</td><tr>";
                }

              //}
            }

          }else if($row_pregunta[1] == 4){
            $filtro_general = "AND n_resultados.id_persona = '$row_cadena[0]' AND id_encuesta = '$encuesta'";

            $cadena2 = mysqli_query($conexion,"SELECT id, respuesta FROM n_respuestas WHERE id_pregunta = '$row_pregunta[0]'");
            $cadena_ul = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                FROM n_resultados
                                                INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
            $cantidad_ul = mysqli_num_rows($cadena_ul);
            if($cantidad_ul != 0){
              $titulo .="<th><center>Cantidad de Encuestados</center></th>";
              $cadena4 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                                                  FROM n_resultados
                                                  INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona
                                                  WHERE n_resultados.id_pregunta = '$row_pregunta[0]'
                                                  AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
              $cantidad1 = mysqli_num_rows($cadena4);
              $cuerpo .="<td><center><label>$cantidad1</label></center></td>";

              while ($row_respuesta = mysqli_fetch_array($cadena2)) {

                $cadena3 = mysqli_query($conexion,"SELECT respuesta FROM n_resultados INNER JOIN n_invitados ON n_invitados.codigo_trabajador = n_resultados.id_persona WHERE id_pregunta = '$row_pregunta[0]' AND respuesta = '$row_respuesta[0]' AND n_resultados.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_general);
                $cantidad = mysqli_num_rows($cadena3);
                $cantidad = ($cantidad == "")?0:$cantidad;

                $porcentaje = porcentaje($cantidad1,$cantidad,2).'%';

                $titulo .= "<th><center>$row_respuesta[1]</center></th>";
                $cuerpo .="<td><center><label>$porcentaje</label> ($cantidad)</center></td>";

              }
            }            
          }
          if($cantidad_ul != 0){
            $button = "<button class='btn btn-danger'>$nombre_trabajador</button>";
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
          echo $sucur;
          echo $button.$tabla;
          $tabla = "";
        }
      }
    }
 ?>