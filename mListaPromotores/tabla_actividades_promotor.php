<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date("Y-m-j");
  $hora_actual  = date('H:i:s');
  
  $id_promotor  = $_POST['id_promotor'];
  
  $cadena   = "SELECT id,actividad FROM actividades_promotor WHERE id_promotor = '$id_promotor' AND activo = '1' AND (temporal = '0' OR fecha = '$fecha_actual')";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo      = "";
  $numero      = 1;
  $texto       = "";
  $disabled    = "";
  $color       = "";
  $hora_inicio = "-";
  $hora_fin    = "-";
  $duracion    = "-";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $verificar = mysqli_query($conexion,"SELECT id,id_actividad,hora_inicio,hora_fin,duracion FROM registro_actividades WHERE id_actividad = '$row[0]' AND fecha = '$fecha' AND id_sucursal = '$id_sede'");
    $tarea_proceso = mysqli_num_rows($verificar);

    $row2 = mysqli_fetch_array($verificar);
    if($tarea_proceso == 0){
      $disabled = "";
      $texto    = "Iniciar";
      $color    = "danger";
    }else{
      $hora_inicio = ($row2[2] == "")?"-":$row2[2];
      $hora_fin    = ($row2[3] == "")?"-":$row2[3];
      $duracion    = ($row2[4] == "")?"-":$row2[4];
      if($row[0] == $row2[1] && $hora_fin == "-"){
        $texto    = "Terminar";
        $disabled = "";  
        $color    = "warning";
      }else{
        $texto    = "Terminada";
        $disabled = "disabled = 'disabled'";  
        $color    = "success";
      }
    }
    $cadena2 = mysqli_query($conexion,"SELECT registro_actividades.id_actividad FROM registro_actividades
                INNER JOIN actividades_promotor ON actividades_promotor.id = registro_actividades.id_actividad
                INNER JOIN promotores ON promotores.id = actividades_promotor.id_promotor
                WHERE promotores.id = '$id_promotor' AND registro_actividades.fecha = '$fecha' AND registro_actividades.duracion is null AND registro_actividades.hora_fin is null AND registro_actividades.id_sucursal = '$id_sede'");
    $existe2 = mysqli_num_rows($cadena2);
    $row3 = mysqli_fetch_array($cadena2);
    if($existe2 != 0){
      if($row3[0] == $row2[1]){
        $disabled = "";
      }else{
        $disabled = "disabled = 'disabled'";
      }
    }else{
      $disabled = "";
    }

    $boton    = "<button class='btn btn-sm btn-$color' $disabled onclick='iniciar_actividad($row[0])'>$texto</button>";
    $iniciar  = "<span class='badge bg-green'>$hora_inicio</span>";
    $fin      = "<span class='badge bg-red'>$hora_fin</span>";
    $duracion = "<span class='badge bg-blue'>$duracion</span>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Actividad\": \"$row[1]\",
      \"Inicio\": \"$iniciar\",
      \"Fin\": \"$fin\",
      \"Duracion\": \"$duracion\",
      \"Iniciar\": \"$boton\"
      },";
    $cuerpo     = $cuerpo.$renglon;
    $numero ++;
    $hora_inicio = "-";
    $hora_fin    = "-";
    $duracion    = "-";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>