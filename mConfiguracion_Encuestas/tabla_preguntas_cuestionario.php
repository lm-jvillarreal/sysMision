<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  $folio = $_POST['folio'];

  $cadena  = "SELECT
                encuestas.id,
                preguntas.pregunta
              FROM
                encuestas
              INNER JOIN preguntas ON preguntas.id = encuestas.id_pregunta
              WHERE
                encuestas.folio_cuestionario = '$folio'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $total  = 0;
  $numero = 1;
  $boton_eliminar = "";
  $clase="";

  while ($row_preguntas = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar = "<button class='btn btn-danger' onclick='eliminar($row_preguntas[0])'>Eliminar</button>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Pregunta\": \"$row_preguntas[1]\",
      \"Eliminar\": \"$boton_eliminar\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $total = 0;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>