<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha = date("Y-m-d"); 
  $hora  = date ("h:i:s");

  $id = $_POST['id'];
  
  $cadena = mysqli_query($conexion,"SELECT
                                      nombre,
                                      ap_paterno,
                                      ap_materno,
                                      sexo,
                                      fecha_nacimiento,
                                      desc_alergia,
                                      edad,
                                      alergias
                                    FROM
                                      pacientes
                                    WHERE
                                      id = '$id'");

  $row = mysqli_fetch_array($cadena);
  $array  = array(
                    $row[0], //nombre
                    $row[1], //ap_paterno
                    $row[2], //ap_materno
                    $row[3], //sexo
                    $row[4], //fecha_nacimiento
                    $row[5], //desc_alergia
                    $row[6], //edad
                    $row[7], //alergia
                  );
  $array1 = json_encode($array);
  echo $array1; 
?>