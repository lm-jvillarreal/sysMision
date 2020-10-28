<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date("Y-m-j");
  $hora_actual  = date('H:i:s');
  
  $id_promotor  = $_POST['id_promotor'];
  
  $cadena   = "SELECT id,actividad FROM actividades_promotor WHERE id_promotor = '$id_promotor' AND activo = '1' AND temporal = '0'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo      = "";
  $numero      = 1;

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_editar = "<button class='btn btn-warning' onclick='editar_actividad($row[0])'>Editar</button>";
    $boton_eliminar = "<button class='btn btn-danger' onclick='eliminar_actividad($row[0])'>Eliminar</button>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Actividad\": \"$row[1]\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\"
      },";
    $cuerpo     = $cuerpo.$renglon;
    $numero ++;
    $clase      = "";
    $cronometro = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>