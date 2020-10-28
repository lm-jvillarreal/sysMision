<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha = date('Y-m-d');
  $hora  = date('H:i:s');

  $id_actividad = $_POST['id_actividad'];
  $mensaje = "";

  $cadena_promotor = mysqli_query($conexion,"SELECT id_promotor,principal FROM actividades_promotor WHERE id = '$id_actividad'");
  $row_promotor = mysqli_fetch_array($cadena_promotor);

  $verificar = mysqli_query($conexion,"SELECT id, hora_inicio FROM registro_actividades WHERE id_actividad = '$id_actividad' AND fecha = '$fecha' AND id_sucursal = '$id_sede'");
  $existe = mysqli_num_rows($verificar);
  $row    = mysqli_fetch_array($verificar);

  if($existe == 0){
    $cadena_registrar = mysqli_query($conexion,"INSERT INTO registro_actividades (id_actividad, hora_inicio, fecha, hora, activo, id_usuario,id_sucursal) VALUES('$id_actividad','$hora','$fecha','$hora','1','$id_usuario','$id_sede')");
    $mensaje = "ok";
  }else{
    $fecha1 = new DateTime($fecha.' '.$row[1]);//fecha inicial
    $fecha2 = new DateTime($fecha.' '.$hora);//fecha de cierre

    $intervalo = $fecha1->diff($fecha2);
    $diferencia = $intervalo->format('%H:%i:%s');
    
    $cadena_registrar = mysqli_query($conexion,"UPDATE registro_actividades SET hora_fin = '$hora', duracion = '$diferencia' WHERE id = '$row[0]'");
    $mensaje = "ok2";
  }

  $array = array($mensaje, $row_promotor[0], $row_promotor[1]);
  echo json_encode($array);
?>