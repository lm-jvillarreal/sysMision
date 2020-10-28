<?php
  include '../global_seguridad/verificar_sesion.php';

  $numero_serie = $_POST['numero_serie'];

  if (strlen(stristr($numero_serie,'-'))>0) {
  }
  else{
    ////////////////////Agrega giones///////////////////////
    $numero_serie = wordwrap($numero_serie,3, "-",1);
  }

  // ////////////////////Remplaza giones///////////////////////
  // $numero_serie = str_replace("-","",$numero_serie);

  $cadena = mysqli_query($conexion,"SELECT id FROM control_equipos WHERE numero_serie = '$numero_serie'");

  $existe = mysqli_num_rows($cadena);

  $mensaje=($existe!="0")?"Existe":"No Existe";

  echo $mensaje;
?>