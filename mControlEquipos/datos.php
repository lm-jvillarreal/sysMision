<?php
  include '../global_seguridad/verificar_sesion.php';

  $id_equipo    = $_POST['id'];

  $cadena = mysqli_query($conexion,"SELECT
                                    (
                                      SELECT
                                        marca
                                      FROM
                                        marcas
                                      WHERE
                                        marcas.id = control_equipos.id_marca
                                    ),
                                    (
                                      SELECT
                                        modelo
                                      FROM
                                        modelos
                                      WHERE
                                        modelos.id = control_equipos.id_modelo
                                    ),
                                    (
                                      SELECT
                                        CONCAT(
                                          nombre,
                                          ' ',
                                          (
                                            SELECT
                                              nombre
                                            FROM
                                              sucursales
                                            WHERE
                                              sucursales.id = cajas.id_sucursal
                                          )
                                        )
                                      FROM
                                        cajas
                                      WHERE
                                        cajas.id = control_equipos.id_caja
                                    ),
                                    numero_serie,
                                    id_caja
                                  FROM
                                    control_equipos
                                  WHERE
                                    id = '$id_equipo'");

  $row    = mysqli_fetch_array($cadena);
  $nombre = $row[2].' - '.$row[0].' '.$row[1];

  $array = array($nombre,$row[3],$row[4]);
  echo json_encode($array);
?>