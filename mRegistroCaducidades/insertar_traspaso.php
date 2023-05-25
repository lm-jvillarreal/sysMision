<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$ide = $_POST['ide'];
$suc = $_POST['ide'];
$max = $_POST['max'];
$cantidad = $_POST['cantidad'];

if($cantidad>$max){
    echo "excedido";
}else{
    $cadenaUpdate="UPDATE far_medicamentosCaducan SET cantidad='$cantidad' WHERE id='$ide'";
    $cantidad=mysqli_query($conexion,$cadenaUpdate);
    echo $cadenaUpdate;
}
?>