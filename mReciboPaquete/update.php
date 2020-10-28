<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$folio = $_POST["folio"];
$comentarios = $_POST["comentarios"];

if($comentarios == null)
{
    echo"1";
}
else
{   
    $qry = "UPDATE materiales
            SET comentarios = '$comentarios',
             activo = '3'
            WHERE
                folio = '$folio'";
    $result = mysqli_query($conexion, $qry);
    echo"2";   
}
?>