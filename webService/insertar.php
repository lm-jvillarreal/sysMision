<?php
include '../global_settings/conexion.php';

  $nombre = $_POST['nombre'];
  $ap_paterno = $_POST['ap_paterno'];
  $ap_materno = $_POST['ap_materno'];
  $cadenaInsertar = "INSERT INTO ejemplo_insertar (nombre, ap_paterno, ap_materno)VALUES('$nombre','$ap_paterno','$ap_materno')";
  $insertarPersona = mysqli_query($conexion,$cadenaInsertar);
?>