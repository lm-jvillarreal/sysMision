<?php 
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$consulta=mysqli_query($conexion,"SELECT
                                      id,
                                      nombre
                                  FROM
                                      sistemas
                                  WHERE
                                      activo = '1'");
    while ($row=mysqli_fetch_row($consulta))
        {   
           echo  "<option value='$row[0]'>$row[0].- $row[1]</option>";
        }                                            
?>