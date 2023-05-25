<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');

  $id_caja = $_POST['id_caja'];
  
  $cadena  = "SELECT he.id,he.num_reporte,he.fecha_llegada,fe.nombre,he.num_serie_anterior,he.num_serie,he.actualizo,he.falla
  FROM historial_equipos he, fallas_equipos fe
  WHERE he.activo = '1'
  AND he.falla = fe.id
              AND id_caja = '$id_caja'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo    = "";
  $numero    = 1;
  $activo    = "";
  $verificar = "";
  $clase = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $clase = ($row[6] == "0")?"":"disabled";

    $link = "<center><button href='#' data-id = '$row[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-primary' target='blank'".$clase.">Actualizar</button></center>";

    $boton_eliminar = "<button onclick='eliminar_reporte($row[0])' class='btn btn-danger'".$clase."><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    $boton_editar   = "<button class='btn btn-warning' onclick='editar_reporte($row[0])'".$clase."><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"# Reporte\": \"$row[1]\",
      \"Fecha Llegada\": \"$row[2]\",
      \"Falla\": \"$row[3]\",
      \"SN\": \"$row[5]\",
      \"SA\": \"$row[4]\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\",
      \"Actualizar\": \"$link\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $clase = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>