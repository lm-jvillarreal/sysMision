<?php 
  include '../global_seguridad/verificar_sesion.php';

  $cadena  = "SELECT id, nombre FROM sub_departamentos WHERE activo = '1'";
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo   = "";
  $numero   = 1;

  while ($row = mysqli_fetch_array($consulta)) 
  {    
    $eliminar = "<button class='btn btn-danger' onclick='eliminar_sd($row[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    $editar   = "<button class='btn btn-warning' onclick='editar_sd($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row[1]\",
      \"Editar\": \"$editar\",
      \"Eliminar\": \"$eliminar\"
      },";
    $cuerpo    = $cuerpo.$renglon;
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