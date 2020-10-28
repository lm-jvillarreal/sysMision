<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');

  $id_promotor  = $_POST['id_promotor'];
  
  $cadena  = "SELECT id,id_sucursal,(SELECT nombre FROM sucursales WHERE sucursales.id = agenda_promotores.id_sucursal),dia,hora_inicio,hora_fin FROM agenda_promotores WHERE activo = '1' AND id_promotor = '$id_promotor' AND dia > '$fecha'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";
  $hora1 = "";
  $hora2 = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar    = "<a onclick='eliminar_horario($row[0])' class='btn btn-danger'>Eliminar</a>";
    $boton_editar      = "<a class='btn btn-warning' onclick='editar_horario($row[0])'>Editar</a>";

    $hora1 = substr($row[4], 0,5);
    $hora2 = substr($row[5], 0,5);

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Dia\": \"$row[3]\",
      \"Sucursal\": \"$row[2]\",
      \"Horario\": \"$hora1 - $hora2\",
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