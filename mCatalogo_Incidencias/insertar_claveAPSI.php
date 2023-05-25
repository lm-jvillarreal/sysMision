<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');

$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

  $id_registro = $_POST['id_registroo'];
  $clave = $_POST['claveApsi'];
  $nombre=$_POST['nombre'];
  
  if (empty($id_registro)) {
    //Insertar nuevo registro
    $verificar=mysqli_query($conexion,"SELECT id FROM claves_apsi WHERE nombre= '$nombre'");
    $existe = mysqli_num_rows($verificar);

    if($existe == 0){
      $cadena_consulta = mysqli_query($conexion,"INSERT INTO claves_apsi (clave,nombre,fecha,hora,usuario, activo)
      VALUES('$clave','$nombre','$fecha','$hora','$id_usuario','1' )");
      echo "ok_nuevo";
     }else{
   
      echo "duplicado";
    }
  }elseif (!empty($id_registro)) {
    $cadena_actualizar = "UPDATE claves_apsi SET clave = '$clave', nombre = '$nombre', fecha = '$fecha', hora='$hora', activo = '1', usuario='$id_usuario' WHERE id = '$id_registro'";
    $consulta_actualizar = mysqli_query($conexion, $cadena_actualizar);
    echo "ok_actualizado";
  
}
?>
