<?php
  include '../global_seguridad/verificar_sesion.php';

  $id = $_POST['id'];

  $cadena   = "SELECT id_persona,(SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM personas WHERE personas.id = me_control_tiempos.id_persona) FROM me_control_tiempos WHERE id = '$id'";
  $consulta = mysqli_query($conexion, $cadena);
  $row      = mysqli_fetch_array($consulta);

  $cadena_horas = mysqli_query($conexion,"SELECT tabla.Persona,tabla.Extra,IFNULL(tabla.Permiso,0),
                SEC_TO_TIME(IFNULL(tabla.Extra,0) - IFNULL(tabla.Permiso,0))
                      FROM
                      (
                          SELECT
                              me_control_tiempos.id_persona AS Persona,
                              (
                                  SELECT
                                      SUM(TIME_TO_SEC(diferencia))
                                  FROM
                                      me_control_tiempos me1
                                  WHERE
                                      activo = '1'
                                  AND me1.id_persona = me_control_tiempos.id_persona
                                  AND me1.tipo = '1'
                              ) AS Extra,
                              (
                                  SELECT
                                      SUM(TIME_TO_SEC(diferencia))
                                  FROM
                                      me_control_tiempos me1
                                  WHERE
                                      activo = '1'
                                  AND me1.id_persona = me_control_tiempos.id_persona
                                  AND (me1.tipo = '2' OR me1.tipo = '3')
                              ) AS Permiso
                          FROM
                              me_control_tiempos
                              WHERE id_persona = '$row[0]'
                          GROUP BY id_persona
                      ) AS tabla");
  $row_hora = mysqli_fetch_array($cadena_horas);

  $array2 = array(
  	$row[1], //Nombre
  	$row_hora[3], //Diferencia Horas
  	$row_hora[3], //Solo datos
  	$row[0] //id_persona
  );

  $array = json_encode($array2);
  echo "$array";
?>