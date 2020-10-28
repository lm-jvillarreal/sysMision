<?php
  include '../global_seguridad/verificar_sesion.php';
  $id_usuarios = $_POST['id_usuario'];

  $cadena = mysqli_query($conexion,"SELECT id,(SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM personas WHERE personas.id = usuarios.id_persona) FROM usuarios WHERE id = '$id_usuarios'");
  $cadena2 = mysqli_query($conexion,"SELECT ant2017,ant2018,actual,id FROM vacaciones WHERE id_usuario = '$id_usuarios'");

  $row = mysqli_fetch_array($cadena);
  $row2 = mysqli_fetch_array($cadena2);
  $array =  array($row[0], //id_persona
  				$row[1], //nombre_persona
  				$row2[0], //2017
  				$row2[1], //2018
  				$row2[2], //actual
          $id_usuarios,
          $row2[3] 
  			);
  echo json_encode($array);

?>