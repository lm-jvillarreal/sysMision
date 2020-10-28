<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $id_pregunta = $_POST['id_pregunta'];

  $cadena  = "  SELECT
                  respuesta,
                  s.nombre,
                  p.tipo_pregunta
                FROM
                  resultados_encuestas re
                INNER JOIN sucursales s ON re.id_sucursal = s.id
                INNER JOIN preguntas p ON p.id = re.id_pregunta
                WHERE
                  re.id_pregunta = '$id_pregunta'
                AND re.activo = '1'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo         = "";
  $total          = 0;
  $numero         = 1;
  $boton_eliminar = "";
  $departamentos  = "";
  $cadena = "";
  $respuesta = "";

  while ($row_respuesta = mysqli_fetch_array($consulta)) 
  {
    if ($row_respuesta[2] == 2){
      if ($row_respuesta[0] == 1){
        $respuesta = "Bueno";
      }
      if ($row_respuesta[0] == 2){
        $respuesta = "Malo";
      }
      if ($row_respuesta[0] == 3){
        $respuesta = "Regular";
      }
    }
    else{
      $respuesta = $row_respuesta[0];
    }
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Pregunta\": \"$row_respuesta[1]\",
      \"Respuesta\": \"$respuesta\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $total = 0;
    $departamentos = "";
    $cantidad = 0;
    $numero2 = 0;
    $respuesta = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>