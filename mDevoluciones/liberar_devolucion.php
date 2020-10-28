<?php
//se manda llamar la conexion
include '../global_seguridad/verificar_sesion.php';

$id_devolucion = $_POST['ide'];
//se extrae de una funcion date
date_default_timezone_set('America/Monterrey');
$fecha=date('Y-m-d');
$hora = date('H:i:s');

$insertar = "UPDATE devoluciones 
                SET fecha_liberacion = '$fecha',
                    hora_liberacion = '$hora',
                    usuario = '$id_usuario',
                    status = '1'
                WHERE id = '$id_devolucion'";

$result = mysqli_query($conexion, $insertar);

echo "ok";
?>
