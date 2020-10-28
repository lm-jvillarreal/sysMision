<?php 
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$consulta=mysqli_query($conexion,"SELECT
                                      id,
                                      nombre
                                  FROM
                                      bodega
                                  WHERE
                                      activo = '1'");
$row=mysqli_fetch_row($consulta);  
echo "$row[1]";                
?>