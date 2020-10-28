<?php
  
  include '../global_seguridad/verificar_sesion.php';

  $id_usu       = $_POST['id_usuario'];
  $dias  = $_POST['dias'];
  // $anterior2017 = $_POST['dias'];
  // $anterior2018 = $_POST['anterior2018'];
  // $actual       = $_POST['vigente'];
  $id_registro  = $_POST['id_registro'];

  if($id_registro == 0){
    $cadena_verificar = mysqli_query($conexion,"SELECT id FROM vacaciones WHERE id_usuario = '$id_usu'");
    $cantidad         = mysqli_num_rows($cadena_verificar);

    if ($cantidad == 0){
      // $cadena = mysqli_query($conexion,"INSERT INTO vacaciones (id_usuario,ant2017,ant2018,actual,usados,fecha,hora,activo,id_usuario_registro)
      //         VALUES ('$id_usu','$anterior2017','$anterior2018','$actual','0','$fecha','$hora','1','$id_usuario')");
      $cadena = mysqli_query($conexion,"INSERT INTO vacaciones (id_usuario,ant2017,ant2018,actual,usados,fecha,hora,activo,id_usuario_registro)
              VALUES ('$id_usu','0','0','$dias','0','$fecha','$hora','1','$id_usuario')");
      echo "ok";
    }
    else{
      echo "duplicado";
    }
  }else{
    $cadena = mysqli_query($conexion,"UPDATE vacaciones SET ant2017 = '0', ant2018 = '0', actual = '$dias' WHERE id = '$id_registro'");
    echo "ok";
  }

?>