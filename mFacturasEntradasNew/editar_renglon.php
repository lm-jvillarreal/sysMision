<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$id = $_POST["id"];
$impuesto = $_POST["impuesto"];
$diferencia = $_POST["diferencia"];
$total = $_POST["total"];

$sql = "UPDATE detalle_nota 
        SET clave_impuesto = '$impuesto',
            diferencia= '$diferencia',
            total= '$total'
        WHERE id ='$id'";
        echo "$sql";
$exSql = mysqli_query($conexion, $sql);

?>