<?php
  include '../global_seguridad/verificar_sesion.php';
  $id_usuarios = $_POST['id_usuario'];

  $cadena = mysqli_query($conexion,"SELECT actual FROM vacaciones WHERE id_usuario = '$id_usuarios'");

  $row = mysqli_fetch_array($cadena);
    echo $row[0];

?>