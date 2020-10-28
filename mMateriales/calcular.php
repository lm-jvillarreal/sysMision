<?php 
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$codigo = $_POST["codigo"];
$existencia = $_POST["existencia"];
$bodega = $_POST["bodega"];


$consulta=mysqli_query($conexion,"SELECT
                                      h.id,
                                      h.codigo,
                                      h.existencia
                                  FROM
                                      historial_existencia_materiales h
                                  WHERE
                                      h.codigo = '$codigo'
                                  AND h.id_bodega = '$bodega'");
$row = mysqli_fetch_array($consulta);

echo"$row[2]";                                           
?>