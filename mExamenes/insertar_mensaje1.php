<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

  $id_registro = $_POST['id_registro'];
  $mensaje = $_POST['nuevo_mensaje'];
  $audio = $_POST['audio'];
  $imagen = $_POST['imagen'];
  //id_codigo= id_registro= num consecutivo de bd

  if (empty($id_registro)) {
    //Insertar nuevo registro
    $verificar=mysqli_query($conexion,"SELECT id FROM mensajes WHERE id= '$id_registro'");
    $existe = mysqli_num_rows($verificar);

    if($existe == 0){
      $cadena_insertar = "INSERT INTO incidencias (nombre,departamento,incidencia,fecha,hora,activo, usuario, folio, comentario, categoria,sucursal)
      VALUES('$nombre','$departamento','$incidencia','$fecha','$hora', '1', '$id_usuario', '0','$comentario', '$categoria','$sucursal')";
     // $insertar_registro = mysqli_query($conexion,$cadena_insertar);
      echo "ok_nuevo";
    }
    else{
      echo "";
    }
  }elseif (!empty($id_registro)) {
    $cadena_actualizar = "UPDATE incidencias SET nombre = '$nombre', incidencia='$incidencia',  fecha = '$fecha', hora='$hora', activo='$activo', usuario='$usuario', comentario='$comentario' WHERE id = '$id_registro'";
   // $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "ok_actualizado";
  }
?>
