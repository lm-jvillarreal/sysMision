<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $cadena   = "SELECT
                id_promotor,
                (
                  SELECT
                    CONCAT(
                      promotores.nombre,
                      ' ',
                      promotores.ap_paterno
                    )
                  FROM
                    promotores
                  WHERE
                    promotores.id = registro_entrada.id_promotor
                ) AS Promotor,
              (
                  SELECT
                    compañia
                  FROM
                    promotores
                  WHERE
                    promotores.id = registro_entrada.id_promotor
                ) AS Compañia,
                hora_entrada
              FROM registro_entrada
              WHERE hora_salida is null";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";
  $actividad = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $cadena_actividades = mysqli_query($conexion,"SELECT id FROM actividades_promotor WHERE id_promotor = '$row[0]'");
    $cadena2 = mysqli_query($conexion,"SELECT actividades_promotor.actividad
              FROM registro_actividades
              INNER JOIN actividades_promotor ON actividades_promotor.id = registro_actividades.id_actividad  
              WHERE registro_actividades.fecha = '2019-07-16' 
              AND registro_actividades.hora_inicio != '' 
              AND registro_actividades.duracion IS NULL 
              AND registro_actividades.hora_fin IS NULL
              AND actividades_promotor.id_promotor = '$row[0]'");
    $row2 = mysqli_fetch_array($cadena2);
    $actividad = ($row2[0] == '')?'Ninguna':$row2[0];
    $renglon = "
      {
      \"#\": \"$numero\",
      \"NombreP\": \"$row[1]\",
      \"Compañia\": \"$row[2]\",
      \"HE\": \"$row[3]\",
      \"Actividad\": \"$actividad\"
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