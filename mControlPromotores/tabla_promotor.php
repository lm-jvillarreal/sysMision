<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  $id_promotor = $_POST['id_promotor'];
  
  $cadena  = "SELECT  dia AS fechaN,
                DATE_FORMAT(dia, '%d/%m/%Y') AS F,
                CASE DAYOFWEEK(dia)
                  WHEN '1' THEN
                    'Domingo'
                  WHEN '2' THEN
                    'Lunes'
                  WHEN '3' THEN
                    'Martes'
                  WHEN '4' THEN
                    'Miercoles'
                  WHEN '5' THEN
                    'Jueves'
                  WHEN '6' THEN
                    'Viernes'
                  ELSE
                    'Sabado'
                  END AS Dia
              FROM
                agenda_promotores
              WHERE
                id_promotor = '$id_promotor'
                ORDER BY fechaN";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Fecha\": \"$row[1]\",
      \"Dia\": \"$row[2]\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>