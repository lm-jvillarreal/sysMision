<?php
    include '../global_seguridad/verificar_sesion.php';

    $cadena = "SELECT id,nombre FROM rublos WHERE activo = '1'";
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo    = "";
    $numero    = 1;

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar = "<a onclick='eliminar_rublo($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $boton_editar   = "<a class='btn btn-warning' onclick='editar_rublo($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";

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