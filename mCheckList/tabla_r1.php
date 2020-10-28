<?php 
  include '../global_seguridad/verificar_sesion.php';

  $checklist = $_POST['checklist'];
  $sucursal  = $_POST['sucursal'];
  
  $fecha1  = $_POST['fecha1'];
  $fecha2  = $_POST['fecha2'];

  $cuerpo   = "";
  $numero   = 1;
  $promedio = 0;

  if(empty($checklist) || empty($sucursal)){
    echo "[]";
    return false;
  }

  # Fecha como segundos
  $tiempoInicio = strtotime($fecha1);
  $tiempoFin    = strtotime($fecha2);
  # 24 horas * 60 minutos por hora * 60 segundos por minuto
  $dia = 86400;
  while($tiempoInicio <= $tiempoFin){
    $fechaActual = date("Y-m-d", $tiempoInicio);
    #Verificacion de Usuario
    $cadena = mysqli_query($conexion,"SELECT resultados_checklist.id,(
                                        SELECT CONCAT( personas.nombre, ' ', personas.ap_paterno, ' ', personas.ap_materno ) 
                                        FROM usuarios
                                        INNER JOIN personas ON personas.id = usuarios.id_persona 
                                        WHERE usuarios.id = resultados_checklist.id_usuario 
                                        ), checklist.tipo 
                                      FROM resultados_checklist 
                                      INNER JOIN checklist ON checklist.id = resultados_checklist.id_checklist
                                      WHERE id_checklist = '$checklist' 
                                      AND resultados_checklist.id_sucursal = '$sucursal' 
                                      AND resultados_checklist.activo = '1' 
                                      AND resultados_checklist.fecha = '$fechaActual'");
    $row = mysqli_fetch_array($cadena);
    $cadena2 = mysqli_query($conexion,"SELECT SUM(calificacion) FROM detalle_resultados_checklist WHERE id_resultado = '$row[0]' AND activo = '1'");
    $row2 = mysqli_fetch_array($cadena2);

    $cadena3 = mysqli_query($conexion,"SELECT COUNT(*) FROM detalle_checklist WHERE id_checklist = '$checklist' AND activo = '1'");
    $row3 = mysqli_fetch_array($cadena3);

    $promedio = ($row2[0] == 0)?"0":round($row2[0] / $row3[0],2);
    // echo $row2[0].'-';

    $cadena4 = mysqli_query($conexion,"SELECT AVG(calificacion) FROM detalle_resultados_checklist WHERE id_resultado = '$row[0]' AND activo = '1'");
    $row4 = mysqli_fetch_array($cadena4);
    $promedio2 = round($row4[0],2);

    $calificacion = "<center><b>$row2[0]</b></center>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Fecha\": \"$fechaActual\",
      \"Calificacion\": \"$promedio2\",
      \"Usuario\": \"$row[1]\"
      },";
    $cuerpo    = $cuerpo.$renglon;
    $numero ++;
    # Sumar el incremento para que en algún momento termine el ciclo
    $tiempoInicio += $dia;
  }

  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>