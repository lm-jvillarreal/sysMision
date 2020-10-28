<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha = date("Y-m-d"); 
  $hora  = date ("h:i:s");

  $id = $_POST['id'];
  
  $cadena = mysqli_query($conexion,"SELECT
                                      id_persona,
                                      (SELECT CONCAT(nombre,' ',ap_paterno,' ', ap_materno) FROM personas WHERE personas.id = medicos.id_persona),
                                      cedula,
                                      instituciones,
                                      especialidad
                                    FROM
                                      medicos
                                    WHERE
                                      id = '$id'");

  $row = mysqli_fetch_array($cadena);
  $array  = array(
                    $row[0], //id_persona
                    $row[1], //nombre_persona
                    $row[2], //cedula
                    $row[3], //instituciones
                    $row[4]  //especialidad
                  );
  $array1 = json_encode($array);
  echo $array1; 
?>