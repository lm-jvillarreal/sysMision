<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

  $id_registro  = $_POST['id_registro'];
  $nombre       = $_POST['id_persona'];
  $departamento = $_POST['departamento'];
  $sucursal     = $_POST['sucursal'];
  $hora_inicio  = $_POST['fecha_inicio'];
  $hora_final   = $_POST['fecha_fin'];
  $motivo       = $_POST['motivo'];
  

  // $fecha_inicio = substr($hora_inicio, 0, 10);
  // $fecha_final  = substr($hora_final, 0, 10);
  // $hora_inicio  = substr($hora_inicio, 11,5);
  // $hora_final   = substr($hora_final, 11,5);
  $tiempo       = $_POST['tiempo'];
  $comentario   = $_POST['comentario'];

  if(!isset($_POST['otro'])){
    $motivoOtro = "";
  }else{
    $motivoOtro = $_POST['otro'];
  }
  
  if (empty($id_registro)) {
    //Insertar nuevo registro
        if(empty($motivoOtro)){
          $cadena_insertar = "INSERT INTO tiempo_extra (nombre,
            departamento,
            sucursal,
            hora_inicio,
            hora_final,
            tiempo,
            comentario,
            fecha,
            hora,
            activo,
            usuario,
            folio,
            fecha_inicio,
            fecha_final,
            motivo,
            motivoOtro)
            VALUES('$nombre','$departamento','$sucursal','$hora_inicio','$hora_final', '$tiempo','$comentario','$fecha','$hora', '1', '$id_usuario', '1','$fecha','$fecha','$motivo',null)";
      //  $insertar_registro = mysqli_query($conexion,$cadena_insertar);
      //echo $cadena_insertar;
       echo "$cadena_insertar";
  }
    else if(!empty($motivoOtro)){
      $cadena_insertar = "INSERT INTO tiempo_extra (nombre,
      departamento,
      sucursal,
      hora_inicio,
      hora_final,
      tiempo,
      comentario,
      fecha,
      hora,
      activo,
      usuario,
      folio,
      fecha_inicio,
      fecha_final,
      motivo,
      motivoOtro)
      VALUES('$nombre','$departamento','$sucursal','$hora_inicio','$hora_final', '$tiempo','$comentario','$fecha','$hora', '1', '$id_usuario', '1','$fecha','$fecha','$motivo','$motivoOtro')";
      
      // $insertar_registro = mysqli_query($conexion,$cadena_insertar);
      echo "$cadena_insertar";
    }
  }else if (!empty($id_registro)) {
    if(empty($motivoOtro)){
      $cadena_actualizar = "UPDATE tiempo_extra 
      SET nombre = '$nombre',
      departamento = '$departamento',        
      sucursal = '$sucursal',
      fecha_inicio= '$hora_inicio',
      fecha_final= '$hora_final',
      tiempo = '$tiempo',
      motivo= '$motivo',
      comentario = '$comentario',
      fecha = '$fecha',
      hora = '$hora',
      activo = '1',
      usuario = '$id_usuario',
      motivoOtro=''
      WHERE
        id = '$id_registro'";
      // $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
      echo "$cadena_actualizar";
    }
    else if(!empty($motivoOtro)){
    $cadena_actualizar = "UPDATE tiempo_extra 
    SET nombre = '$nombre',
    departamento = '$departamento',        
    sucursal = '$sucursal',
    fecha_inicio= '$hora_inicio',
    fecha_final= '$hora_final',
    tiempo = '$tiempo',
    motivo= '$motivo',
    comentario = '$comentario',
    fecha = '$fecha',
    hora = '$hora',
    activo = '1',
    usuario = '$id_usuario',
    motivoOtro='$motivoOtro'
    WHERE
      id = '$id_registro'";
    // $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "$cadena_actualizar";
    }
  }
?>