<?php 
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$consulta=mysqli_query($conexion, "SELECT
                                      MAX(folio)
                                   FROM
                                      materiales");
$row=mysqli_fetch_row($consulta);
if($row[0] == null)
    {
        $folio = 1;
    }
else
    {
        $folio = $row[0] + 1;
    }
echo"$folio";
?>