<?php
  include '../global_seguridad/verificar_sesion.php';

  $id = $_POST['id'];

  $cadena_eliminar = mysqli_query($conexion,"DELETE FROM firmas_autorizadas WHERE id ='$id'");
  $eliminar_registro = mysqli_query($conexion, $cadena_eliminar);

  echo "ok";
?>