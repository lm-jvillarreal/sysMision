<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');

  $cadena  = "SELECT preguntas.id,preguntas.pregunta,departamentos.nombre,
                CASE tipo_pregunta WHEN '1' THEN 'Cuantitativo' WHEN '2' THEN 'Cualitativo' WHEN '3' THEN 'Libre' WHEN '4' THEN 'Cerrada' WHEN '5' THEN 'Cualitativo (Precios)' END AS tipo_pregunta,preguntas.folio,
                CASE id_categoria WHEN '1' THEN 'Frescura y Calidad' WHEN '2' THEN 'Orden y Acomodo de Mercancia' WHEN '3' THEN 'Atencion y Servicio al Cliente' WHEN '4' THEN 'Limpieza en Tienda' WHEN '0' THEN 'No Tiene Categoria' END AS id_categoria
              FROM
                preguntas
              INNER JOIN departamentos ON preguntas.id_departamento = departamentos.id
              WHERE preguntas.activo = '1'
              GROUP BY preguntas.pregunta";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo         = "";
  $total          = 0;
  $numero         = 1;
  $boton_eliminar = "";
  $departamentos  = "";
  $cadena = "";

  while ($row_preguntas = mysqli_fetch_array($consulta)) 
  {
    $cadena1 = mysqli_query($conexion,"SELECT d.nombre FROM preguntas p INNER JOIN departamentos d ON d.id = p.id_departamento WHERE p.pregunta = '$row_preguntas[1]' AND p.activo = '1'");
    $cantidad = mysqli_num_rows($cadena1);
    $numero2 = 1;
    while ($row = mysqli_fetch_array($cadena1)) {
      if ($cantidad == $numero2){
        $departamentos .= $row[0];
      }
      else{
        $departamentos .= $row[0].', ' ;
      }
      $numero2 ++;
    }


    $boton_eliminar = "<button class='btn btn-danger' onclick='eliminar($row_preguntas[4])'>Eliminar</button>";
    $boton_editar = "<a class='btn btn-warning' href='editar_pregunta.php?id=$row_preguntas[0]'>Editar</a>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Pregunta\": \"$row_preguntas[1]\",
      \"Departamento\": \"$departamentos\",
      \"Categoria\": \"$row_preguntas[5]\",
      \"Tipo Pregunta\": \"$row_preguntas[3]\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $total = 0;
    $departamentos = "";
    $cantidad = 0;
    $numero2 = 0;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>