<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');

  $cadena  = "SELECT id_persona FROM me_control_tiempos WHERE activo = '1' GROUP BY id_persona";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $total  = 0;
  $numero = 1;
  while ($row_tiempo = mysqli_fetch_array($consulta)) 
  {
    $date_favor = new DateTime('00:00');
    $date_contra = new DateTime('00:00');

    $cadena_horas1 = "SELECT SUM(HOUR(diferencia)),SUM(MINUTE(diferencia)), CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno)AS Nom
                                      FROM
                                        me_control_tiempos
                                      INNER JOIN personas ON personas.id = me_control_tiempos.id_persona
                WHERE me_control_tiempos.id_persona = '$row_tiempo[0]'
                AND me_control_tiempos.activo = '1'
                AND me_control_tiempos.tipo = '1'";

    $cadena_horas2 = "SELECT SUM(HOUR(diferencia)),SUM(MINUTE(diferencia)), CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno)AS Nom
                                      FROM
                                        me_control_tiempos
                                      INNER JOIN personas ON personas.id = me_control_tiempos.id_persona
                WHERE me_control_tiempos.id_persona = '$row_tiempo[0]'
                AND me_control_tiempos.activo = '1'
                AND me_control_tiempos.tipo = '2'";

    $cadena1 = mysqli_query($conexion,$cadena_horas1);
    $row_cadena1 = mysqli_fetch_array($cadena1);

    $cadena2 = mysqli_query($conexion,$cadena_horas2);
    $row_cadena2 = mysqli_fetch_array($cadena2);

    $cantidad1 = mysqli_num_rows($cadena1);
    $cantidad2 = mysqli_num_rows($cadena2);

    if ($row_cadena1[0] != ""){
      $date_favor->modify('+'.$row_cadena1[0].'hours');  
    }
    if ($row_cadena1[1] != ""){
      $date_favor->modify('+'.$row_cadena1[1].'minute');
    }
    if ($row_cadena2[0] != ""){
      $date_contra->modify('+'.$row_cadena2[0].'hours');
    }
    if ($row_cadena2[1] != ""){
      $date_contra->modify('+'.$row_cadena2[1].'minute');
    }

    $diferencia_favor = $date_favor->format('H:i');
    $diferencia_contra = $date_contra->format('H:i');

    if($diferencia_favor > $diferencia_contra){
      $valor = "+";
    }
    else{
      $valor = "-";
    }

    if ($row_cadena1[2] == ""){
      $nombre = $row_cadena2[2];
    }
    else{
      $nombre = $row_cadena1[2];
    }

    $hora_F = new DateTime($diferencia_favor);
    $hora_C = new DateTime($diferencia_contra);

    $total_horas = $hora_F->diff($hora_C);
    $diferencia = $total_horas->format('%H horas %i minutos');
    if ($diferencia == "00 horas 0 minutos"){
      // echo "no valido";
      continue;
    }

    $usuario = "<a onclick ='abrir($row_tiempo[0])' >$nombre</a>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Usuario\": \"$usuario\",
      \"Diferencia\": \"$valor $diferencia.\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $total = 0;
    $nombre = "";

  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>