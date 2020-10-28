<?php 
  // header("Content-Type: text/html;charset=utf-8");
  include '../global_seguridad/verificar_sesion.php';

  $checklist = $_POST['checklist'];

  $cadena  = "SELECT id,nombre,
              (SELECT nombre FROM sub_departamentos WHERE sub_departamentos.id = detalle_checklist.id_subdepartamento),programada,frecuencia,duracion
              FROM detalle_checklist  
              WHERE activo = '1' AND id_checklist = '$checklist' ORDER BY id DESC";
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo   = "";
  $numero   = 1;

  while ($row = mysqli_fetch_array($consulta)) 
  {    
    $escape_desc = mysqli_real_escape_string($conexion, $row[1]);
    if($row[4] == 1){
      $frecuencia = "Todos los dias";
    }else if($row[4] == 2){
      $frecuencia = "Cada Semana";
    }else if($row[4] == 3){
      $frecuencia = "Cada Quincena";
    }else if($row[4] == 4){
      $frecuencia = "Cada Mes";
    }else if($row[4] == 5){
      $frecuencia = "Cada Año";
    }else{
      $frecuencia = "-";
    }

    if($row[5] == 1){
      $duracion = '15 Minutos';
    }else if($row[5] == 2){ 
      $duracion = '30 Minutos';
    }else if($row[5] == 3){ 
      $duracion = '45 Minutos';
    }else if($row[5] == 4){ 
      $duracion = '1 Hora';
    }else if($row[5] == 5){ 
      $duracion = 'Todo el Dia';
    }else{
      $duracion = '-';
    }

    $programar = ($row[3] == 0)?"<center><button href='#' data-id = '$row[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-info' target='blank'><i class='fa fa-calendar-times-o fa-lg' aria-hidden='true'></i></button></center>":"<center><button href='#' data-id = '$row[0]' data-toggle = 'modal' data-target = '#modal-default2' class='btn btn-success' target='blank'><i class='fa fa-calendar-check-o fa-lg' aria-hidden='true'></i></button></center>";
    $eliminar  = "<center><button class='btn btn-danger' onclick='eliminar($row[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button></center>";
    $editar    = "<center><button class='btn btn-warning' onclick='editar($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$escape_desc\",
      \"SubDepartamento\": \"$row[2]\",
      \"Programar\": \"$programar\",
      \"Frecuencia\": \"$frecuencia\",
      \"Duracion\": \"$duracion\",
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