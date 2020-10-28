<?php
  include '../global_seguridad/verificar_sesion.php';

  $id = $_POST['id'];

  $cadena = "SELECT id, nombre FROM firmas_autorizadas WHERE id ='$id'";

  $consulta = mysqli_query($conexion, $cadena);
  $row      = mysqli_fetch_array($consulta);

$array2 = array(
    $row[1], //Nombre
    //$row[0] //id_persona
  );

  $array = json_encode($array2);
  echo "$array";
?>