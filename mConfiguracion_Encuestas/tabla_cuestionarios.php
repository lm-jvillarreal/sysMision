<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');

  $cadena  = "SELECT id,nombre,DATE_FORMAT(fecha_inicio,'%d/%m/%Y'),DATE_FORMAT(fecha_fin,'%d/%m/%Y'),cantidad_encuestados,encuestados,folio FROM cuestionarios WHERE activo ='1' GROUP BY folio";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $boton_eliminar = "";
  $clase="";
  $restantes = 0;

  while ($row_preguntas = mysqli_fetch_array($consulta)) 
  {
    $restantes = $row_preguntas[4] - $row_preguntas[5];
    $cadena1 = mysqli_query($conexion,"SELECT id FROM encuestas WHERE folio_cuestionario = '$row_preguntas[6]'");
    $cantidad = mysqli_num_rows($cadena1);
    $clase = ($cantidad != 0)?"":"disabled";
    $boton_eliminar = "<button class='btn btn-danger' onclick='eliminar($row_preguntas[6])'>Eliminar</button>";
    $boton_editar = "<a class='btn btn-warning' href='editar_cuestionario.php?folio=$row_preguntas[6]'>Editar</a>";
    $boton_ver = "<a class='btn btn-primary ".$clase."' href='ver_cuestionario.php?id=$row_preguntas[0]'>Vista Previa</a>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row_preguntas[1]\",
      \"Fecha Inicio\": \"$row_preguntas[2]\",
      \"Fecha Fin\": \"$row_preguntas[3]\",
      \"Cantidad de Preguntas\": \"$cantidad\",
      \"Cantidad de Encuestados\": \"$restantes\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\",
      \"Ver\": \"$boton_ver\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $restantes = 0;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>