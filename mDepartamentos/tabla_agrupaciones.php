<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $cadena  = "SELECT id,nombre FROM agrupaciones WHERE activo = '1'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo       = "";
  $numero       = 1;
  $activo       = "";
  $boton_nombre = "";

  while ($row_agrupaciones = mysqli_fetch_array($consulta)) 
  {
    $boton_nombre = "<p id='bnombre$numero' ondblclick='act_nombre($numero)'>$row_agrupaciones[1]</p><input type='text' value='$row_agrupaciones[1]' onblur='act_nom(this.value,$row_agrupaciones[0])' id='input_nombre$numero' class='form-control hidden'>";
  	$eliminar = "<a class='btn btn-danger' onclick='eliminar($row_agrupaciones[0])'>Eliminar</a>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$boton_nombre\",
      \"Eliminar\": \"$eliminar\"
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
