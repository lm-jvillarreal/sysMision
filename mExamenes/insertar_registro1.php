<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

  $id_registro = $_POST['id_registro'];
  $mensaje = $_POST['nuevo_mensaje'];
  $destinos=$_POST['destinos'];

  if (empty($id_registro)) {
    //Insertar nuevo registro
    $verificar=mysqli_query($conexion,"SELECT id FROM mensajes WHERE id= '$id_registro'");
    $existe = mysqli_num_rows($verificar);

    if($existe == 0){
      $cadena_insertar = "INSERT INTO mensajes (mensaje, imagen, audio, destinatario, usuario, fecha, hora, activo)
      VALUES('$mensaje','null','null','$destinos','$usuario','$fecha', '$hora', '1')";
     // $insertar_registro = mysqli_query($conexion,$cadena_insertar);
      echo "$cadena_insertar";
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
