<?php
  include '../global_seguridad/verificar_sesion.php';

  $modelo     = $_POST['modelo'];

  $cadena = mysqli_query($conexion,"SELECT CASE tipo
                                        WHEN '1' THEN
                                          'PINPAD'
                                        WHEN '2' THEN
                                          'DUAL-UP'
                                        WHEN '3' THEN
                                          'GRPS'
                                        ELSE
                                          'Ninguno'
                                        END AS tipo FROM modelos WHERE id = '$modelo'");
  $row    = mysqli_fetch_array($cadena);

  $array = array($row[0]);
  echo json_encode($array);
?>