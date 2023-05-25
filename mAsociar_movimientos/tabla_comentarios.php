<?php
    include '../global_seguridad/verificar_sesion.php';

    $cadena = "SELECT id,nombre FROM errores_movimientos WHERE activo = '1'";
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo    = "";
    $numero    = 1;

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar = "<a onclick='eliminar_comentario($row[0])' class='btn btn-danger'>Eliminar</a>";
    $boton_editar   = "<a class='btn btn-warning' onclick='editar_comentario($row[0])'>Editar</a>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row[1]\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\"
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