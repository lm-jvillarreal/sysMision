<?php 
  include '../global_seguridad/verificar_sesion.php';

  date_default_timezone_set('America/Monterrey');
  $pregunta     = $_POST['pregunta'];  
  $sucursal     = $_POST['sucursal'];  
  $fecha_inicio = $_POST['fecha_inicio'];
  $fecha_fin    = $_POST['fecha_fin'];
  
  $cadena  = "SELECT
                re.respuesta,p.pregunta,re.comentario
              FROM
                resultados_encuestas re 
              INNER JOIN preguntas p ON p.id = re.id_pregunta
              WHERE re.activo = '1'
              AND re.id_pregunta = '$pregunta'
              AND re.id_sucursal = '$sucursal'
              AND re.fecha BETWEEN CAST('$fecha_inicio' AS DATE)
              AND CAST('$fecha_fin' AS DATE)";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo     = "";
  $numero     = 1;
  $comentario = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $comentario = ($row[2] == "")?"No hay Comentarios":"$row[2]";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Pregunta\": \"$row[1]\",
      \"Respuesta\": \"$row[0]\",
      \"Comentario\": \"$comentario\"
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